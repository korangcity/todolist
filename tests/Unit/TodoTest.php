<?php

namespace Tests\Unit;

use App\Livewire\TodoList;
use App\Models\Todo;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class TodoTest extends TestCase
{
//    use RefreshDatabase;
    /**
     * A basic unit test example.
     */
    public function test_can_create_todo(): void
    {
        Livewire::test(TodoList::class)
            ->set('title','foo')
            ->set('description','bar')
            ->set('end_date','2024/10/2')
            ->set('priority','high')
            ->call('store');
        $this->assertTrue(true);
    }

    public function test_can_update_todo():void
    {
        $todo = Todo::create([
            'title' => 'Test Todo',
            'description' => 'Test Description',
            'end_date' => '2024/10/2',
            'priority' => 'high',
            'status'=>'pending'
        ]);

        Livewire::test(TodoList::class)
            ->set('todoId', $todo->id)
            ->set('title', 'Updated Title')
            ->set('description', 'Updated Description')
            ->set('end_date','2024/10/2')
            ->set('priority','high')
            ->call('update');

        $this->assertDatabaseHas('todos', [
            'id' => 24,
            'title' => 'Updated Title',
            'description' => 'Updated Description',
        ]);
    }

    public function test_can_delete_todo():void
    {
        Livewire::test(TodoList::class)
            ->call('delete',28);
        $this->assertDatabaseMissing('todos', ['id' => 28]);
    }


    public function test_can_update_status()
    {
        Livewire::test(TodoList::class)
            ->set('status', 'completed')
            ->call('changeStatus',30);


        $this->assertDatabaseHas('todos', [
            'id' => 30,
            'title' => 'foo',
            'description' => 'bar',
        ]);
    }
}
