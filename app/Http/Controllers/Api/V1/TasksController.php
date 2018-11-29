<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Resources\TasksResource;
use App\Models\Task\Task;
use App\Repositories\Backend\Tasks\TasksRepository;
use Illuminate\Http\Request;
use Validator;

class TasksController extends APIController
{
    protected $repository;

    public function __construct(TasksRepository $repository)
    {
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $limit = $request->get('paginate') ? $request->get('paginate') : 25;
        $orderBy = $request->get('orderBy') ? $request->get('orderBy') : 'ASC';
        $sortBy = $request->get('sortBy') ? $request->get('sortBy') : config('module.tasks.table', 'tasks').'.created_at';

        return TasksResource::collection(
            $this->repository->getForDataTable()->orderBy($sortBy, $orderBy)->paginate($limit)
        );
    }
}