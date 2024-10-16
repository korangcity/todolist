<?php

namespace App\Services;

use App\Models\Todo;

class DeleteTodo
{

    public function execute($id)
    {
        event(new \App\Events\DeleteTodo(Todo::where('id', $id)->first()->title));
        Todo::find($id)->delete();
    }
}
