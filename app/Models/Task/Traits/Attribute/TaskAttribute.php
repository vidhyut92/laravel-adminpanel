<?php

namespace App\Models\Task\Traits\Attribute;

/**
 * Class TaskAttribute.
 */
trait TaskAttribute
{
    /**
     * @return string
     */
    public function getActionButtonsAttribute()
    {
        return '<div class="btn-group action-btn">
                    '.$this->getEditButtonAttribute('edit-task', 'admin.tasks.edit').'
                    '.$this->getDeleteButtonAttribute('delete-task', 'admin.tasks.destroy').'
                </div>';
    }

    /**
     * @return string
     */
    public function getStatusLabelAttribute()
    {
        if ($this->isActive()) {
            return "<label class='label label-success'>".trans('labels.general.active').'</label>';
        }

        return "<label class='label label-danger'>".trans('labels.general.inactive').'</label>';
    }

    public function getIsFeaturedLabelAttribute()
    {
        if ($this->isFeatured()) {
            return "<label class='label label-primary'>".trans('labels.general.yes').'</label>';
        }

        return "<label class='label label-default'>".trans('labels.general.no').'</label>';
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->status == 1;
    }

    public function isFeatured()
    {
        return $this->is_featured == 1;
    }
}
