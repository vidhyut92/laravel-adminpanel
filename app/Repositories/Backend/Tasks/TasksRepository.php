<?php
namespace App\Repositories\Backend\Tasks;

use App\Exceptions\GeneralException;
use App\Models\Task\Task;
use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\Storage;
use App\Events\Backend\Tasks\TaskCreated;
use App\Events\Backend\Tasks\TaskUpdated;
use App\Events\Backend\Tasks\TaskDeleted;

class TasksRepository extends BaseRepository
{
    const MODEL = Task::class;

    protected $upload_path;
    protected $storage;

    public function __construct()
    {
        $this->upload_path = 'img' . DIRECTORY_SEPARATOR . 'tasks' . DIRECTORY_SEPARATOR;
        $this->storage = Storage::disk('public');
    }

    public function fileUpload($input)
    {
        if (empty($input['task_file'])) {
            //don't process if file is not uploaded
            return $input;
        }

        $file = $input['task_file'];
        $fileName = md5(time()) . '.' . $file->getClientOriginalExtension();
        $this->storage->put($this->upload_path . $fileName, file_get_contents($file->getRealPath()));
        $input = array_merge($input, ['task_file' => $fileName]);

        return $input;
    }

    public function create(array $input)
    {
        if ($this->query()->where('title', $input['title'])->first()) {
            throw new GeneralException(trans('exceptions.backend.tasks.already_exists'));
        }

        // Making extra fields
        $input['is_featured'] = isset($input['is_featured']) ? 1 : 0;

        $input = $this->fileUpload($input);

        $input['created_by'] = access()->user()->id;
        
        if ($task = Task::create($input)) {
            event(new TaskCreated($task));
            return $task;
        }

        throw new GeneralException(trans('exceptions.backend.tasks.create_error'));
    }

    public function update($task, array $input)
    {
        if ($this->query()->where('title', $input['title'])->where('id', '!=', $task->id)->first()) {
            throw new GeneralException(trans('exceptions.backend.tasks.already_exists'));
        }

        // Making extra fields
        $input['is_featured'] = isset($input['is_featured']) ? 1 : 0;

        $input = $this->fileUpload($input);

        $input['updated_by'] = access()->user()->id;

        if ($task->update($input)) {
            event(new TaskUpdated($task));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.tasks.update_error'));
    }

    public function getForDataTable()
    {
        return $this->query()
            ->leftjoin(config('access.users_table'), config('access.users_table').'.id', '=', config('module.tasks.table').'.created_by')
            ->select([
                config('module.tasks.table').'.id',
                config('module.tasks.table').'.title',
                config('module.tasks.table').'.status',
                config('module.tasks.table').'.created_at',
                config('module.tasks.table').'.updated_at',
                config('module.tasks.table').'.is_featured',
                config('access.users_table').'.first_name as created_by',
            ]);
    }

    public function delete($task)
    {
        if ($task->delete()) {
            event(new TaskDeleted($task));

            return true;
        }

        throw new GeneralException(trans('exceptions.backend.tasks.delete_error'));
    }
}
