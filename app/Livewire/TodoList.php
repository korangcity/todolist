<?php

namespace App\Livewire;

use App\Events\AddNewTask;
use App\Models\Todo;
use App\Services\ChangeStatusTask;
use App\Services\DeleteTodo;
use App\Services\StoreTodo;
use App\Services\UpdateTodo;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;


class TodoList extends Component
{
    use LivewireAlert;

    public $todos, $title, $description, $status, $end_date, $priority;
    public $updateMode = false;
    public $todoId;


    public function mount()
    {
        $this->getTodos();
    }

    #[On('echo:change-todo-status,ChangeTodoStatus')]
    #[On('echo:deleteTodo,DeleteTodo')]
    #[On('echo:updateTask,UpdateTask')]
    #[On('echo:addTask,AddNewTask')]
    public function getTodos()
    {
        $this->todos = Todo::orderBy('id', 'desc')->get();
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
            $validatedData['status'] = 'pending';
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
        } catch (\Exception $e) {
            Log::error('Error edit Todo: ' . $e->getMessage());
        }
    }

    public function update(UpdateTodo $updateTodo)
    {
        try {
            $validatedData = $this->validate();
            $todo = Todo::find($this->todoId);
            $updateTodo->execute($validatedData, $todo);
            $this->updateMode = false;
            $this->resetInputFields();

        } catch (\Exception $e) {
            Log::error('Error updating Todo: ' . $e->getMessage());
        }
    }

    public function delete($id,DeleteTodo $deleteTodo)
    {
        try {
            $deleteTodo->execute($id);
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

    public function changeStatus($id,ChangeStatusTask $changeStatusTask)
    {
        try {
            $changeStatusTask->execute($id,$this->status);
        } catch (\Exception $e) {
            Log::error('Error updating Todo status: ' . $e->getMessage());
        }
    }

}
