<?php

namespace App\Events\Backend\Tasks;

use Illuminate\Queue\SerializesModels;

/**
 * Class TaskDeleted.
 */
class TaskDeleted
{
    use SerializesModels;

    /**
     * @var
     */
    public $task;

    /**
     * @param $task
     */
    public function __construct($task)
    {
        $this->task = $task;
    }
}
