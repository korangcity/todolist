<?php

namespace App\Services;

use App\Events\ChangeTodoStatus;
use App\Models\Todo;

class ChangeStatusTask
{

    public function execute($id, $status)
    {
        $todo = Todo::find($id);
        event(new ChangeTodoStatus($todo));
        $todo->status = $status;
        $todo->save();

    }
}
