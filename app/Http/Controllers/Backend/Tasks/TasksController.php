<?php
namespace App\Http\Controllers\Backend\Tasks;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Tasks\CreateTaskRequest;
use App\Http\Requests\Backend\Tasks\EditTaskRequest;
use App\Http\Requests\Backend\Tasks\StoreTaskRequest;
use App\Http\Requests\Backend\Tasks\UpdateTaskRequest;
use App\Http\Responses\RedirectResponse;
use App\Http\Responses\ViewResponse;
use App\Models\Task\Task;
use App\Repositories\Backend\Tasks\TasksRepository;
use App\Http\Requests\Backend\Tasks\DeleteTaskRequest;
use App\Http\Requests\Backend\Tasks\ManageTaskRequest;

class TasksController extends Controller
{
    protected $tasks;

    public function __construct(TasksRepository $tasks)
    {
        $this->tasks = $tasks;
    }

    public function index(ManageTaskRequest $request)
    {
        return new ViewResponse('backend.tasks.index');
    }

    public function create(CreateTaskRequest $request)
    {
        return new ViewResponse('backend.tasks.form');
    }

    public function store(StoreTaskRequest $request)
    {
        $this->tasks->create($request->except(['_token']));

        //causing error
        return new RedirectResponse(route('admin.tasks.index'), ['flash_success' => trans('alerts.backend.tasks.created')]);
    }

    public function edit(Task $task, EditTaskRequest $request)
    {
        return new ViewResponse('backend.tasks.form', compact('task'));
    }

    public function update(Task $task, UpdateTaskRequest $request)
    {
        $this->tasks->update($task, $request->except(['_token']));
        return new RedirectResponse(route('admin.tasks.index'), ['flash_success' => trans('alerts.backend.tasks.updated')]);
    }

    public function destroy(Task $task, DeleteTaskRequest $request)
    {
        $this->tasks->delete($task);

        return new RedirectResponse(route('admin.tasks.index'), ['flash_success' => trans('alerts.backend.tasks.deleted')]);

    }

}
