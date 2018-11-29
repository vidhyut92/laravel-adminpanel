<?php
namespace App\Models\Task;

use App\Models\BaseModel;
use App\Models\ModelTrait;
use App\Models\Task\Traits\TaskRelationship;
use App\Models\Task\Traits\Attribute\TaskAttribute;

class Task extends BaseModel
{
    use TaskRelationship,
        ModelTrait,
        TaskAttribute;

    protected $guarded = ['id'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->table = config('module.tasks.table');
    }
}
