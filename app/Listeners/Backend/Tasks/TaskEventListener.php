<?php

namespace App\Listeners\Backend\Tasks;

/**
 * Class TaskEventListener.
 */
class TaskEventListener
{
    /**
     * @var string
     */
    private $history_slug = 'Task';

    /**
     * @param $event
     */
    public function onCreated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->task->id)
            ->withText('trans("history.backend.tasks.created") <strong>'.$event->task->title.'</strong>')
            ->withIcon('plus')
            ->withClass('bg-green')
            ->log();
    }

    /**
     * @param $event
     */
    public function onUpdated($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->task->id)
            ->withText('trans("history.backend.tasks.updated") <strong>'.$event->task->title.'</strong>')
            ->withIcon('save')
            ->withClass('bg-aqua')
            ->log();
    }

    /**
     * @param $event
     */
    public function onDeleted($event)
    {
        history()->withType($this->history_slug)
            ->withEntity($event->task->id)
            ->withText('trans("history.backend.tasks.deleted") <strong>'.$event->task->title.'</strong>')
            ->withIcon('trash')
            ->withClass('bg-maroon')
            ->log();
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe($events)
    {
        $events->listen(
            \App\Events\Backend\Tasks\TaskCreated::class,
            'App\Listeners\Backend\Tasks\TaskEventListener@onCreated'
        );

        $events->listen(
            \App\Events\Backend\Tasks\TaskUpdated::class,
            'App\Listeners\Backend\Tasks\TaskEventListener@onUpdated'
        );

        $events->listen(
            \App\Events\Backend\Tasks\TaskDeleted::class,
            'App\Listeners\Backend\Tasks\TaskEventListener@onDeleted'
        );
    }
}
