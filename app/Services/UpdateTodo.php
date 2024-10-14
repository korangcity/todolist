<?php

namespace App\Services;

use App\Models\Todo;

class UpdateTodo
{

    public function execute($validatedData,Todo $todo)
    {
        $todo->update($validatedData);

        session()->flash('message', 'Todo Updated Successfully.');
    }
}
