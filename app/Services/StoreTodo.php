<?php

namespace App\Services;

use App\Models\Todo;
use Illuminate\Http\Request;

class StoreTodo
{

    public function execute($validatedData)
    {
        Todo::create($validatedData);
        session()->flash('message', 'Todo Created Successfully.');

    }

}
