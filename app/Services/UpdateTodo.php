<?php

namespace App\Services;

use App\Jobs\UpdateTodoJob;
use App\Models\Todo;

class UpdateTodo
{

    public function execute($validatedData,Todo $todo)
    {
        if ($validatedData['priority'] == 'high')
            UpdateTodoJob::dispatch($validatedData,$todo)->onQueue('high');
        elseif ($validatedData['priority'] == 'medium')
            UpdateTodoJob::dispatch($validatedData,$todo)->onQueue('medium');
        else
            UpdateTodoJob::dispatch($validatedData,$todo)->onQueue('low');

        session()->flash('message', 'Todo Updated Successfully.');
    }
}
