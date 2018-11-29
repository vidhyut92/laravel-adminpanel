<?php

namespace App\Events\Backend\Tasks;

use Illuminate\Queue\SerializesModels;

/**
 * Class TaskCreated.
 */
class TaskCreated
{
    use SerializesModels;

    /**
     * @var
     */
    public $task;

    /**
     * @param $page
     */
    public function __construct($task)
    {
        $this->task = $task;
    }
}
