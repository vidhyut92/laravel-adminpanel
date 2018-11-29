<?php

namespace App\Models\Task\Traits;

use App\Models\Access\User\User;

trait TaskRelationship
{
    public function owner()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
