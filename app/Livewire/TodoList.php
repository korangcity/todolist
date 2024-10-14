<?php

namespace App\Livewire;

use App\Models\Todo;
use App\Services\StoreTodo;
use App\Services\UpdateTodo;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class TodoList extends Component
{
    public $todos, $title, $description, $status, $end_date, $priority;
    public $updateMode = false;
    public $todoId;

    public function mount()
    {
        $this->todos = Todo::all();
    }

    public function render()
    {
        return view('livewire.todo-list')->layout('layouts.app');
    }

    protected $rules = [
        'title' => 'required',
        'description' => 'nullable',
        'end_date' => 'nullable|date',
        'priority' => 'required',
    ];

    public function store(StoreTodo $storeTodo)
    {
        try {
            $validatedData = $this->validate();
            $validatedData['status']='pending';
            $storeTodo->execute($validatedData);
            $this->resetInputFields();
        } catch (\Exception $e) {
            Log::error('Error creating Todo: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $todo = Todo::findOrFail($id);
            $this->todoId = $id;
            $this->title = $todo->title;
            $this->description = $todo->description;
            $this->status = $todo->status;
            $this->end_date = $todo->end_date;
            $this->priority = $todo->priority;
            $this->updateMode = true;
        }catch (\Exception $e){
            Log::error('Error edit Todo: ' . $e->getMessage());
        }
    }

    public function update(UpdateTodo $updateTodo)
    {
        try {
            $validatedData = $this->validate();
            $todo = Todo::find($this->todoId);
            $updateTodo->execute($validatedData,$todo);

            $this->updateMode = false;
            $this->resetInputFields();
//            $this->emit('todoUpdated', $validatedData);
        } catch (\Exception $e) {
            Log::error('Error updating Todo: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            Todo::find($id)->delete();
            session()->flash('message', 'Todo Deleted Successfully.');
            $this->emit('todoDeleted', $id);
        } catch (\Exception $e) {
            Log::error('Error deleting Todo: ' . $e->getMessage());
        }
    }

    public function resetInputFields()
    {
        $this->title = '';
        $this->description = '';
        $this->status = 'pending';
        $this->end_date = '';
        $this->priority = 'medium';
    }


}
