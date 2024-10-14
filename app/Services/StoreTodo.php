<?php

namespace App\Services;

use App\Jobs\StoreTodoJob;
use App\Models\Todo;
use Illuminate\Http\Request;

class StoreTodo
{

    public function execute($validatedData)
    {
        if ($validatedData['priority'] == 'high')
            StoreTodoJob::dispatch($validatedData)->onQueue('high');
        elseif ($validatedData['priority'] == 'medium')
            StoreTodoJob::dispatch($validatedData)->onQueue('medium');
        else
            StoreTodoJob::dispatch($validatedData)->onQueue('low');

        session()->flash('message', 'Todo Created Successfully.');

    }

}
