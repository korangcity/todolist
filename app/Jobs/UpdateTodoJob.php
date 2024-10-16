<?php

namespace App\Jobs;

use App\Events\UpdateTask;
use App\Models\Todo;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class UpdateTodoJob implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private $validatedData,private Todo $todo)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->todo->update($this->validatedData);
        event(new UpdateTask($this->todo));
    }
}
