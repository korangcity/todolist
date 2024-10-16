<?php

namespace App\Jobs;

use App\Events\AddNewTask;
use App\Models\Todo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class StoreTodoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private $validatedData)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $todo=Todo::create($this->validatedData);
        event(new AddNewTask($todo));
    }
}
