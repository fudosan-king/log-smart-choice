<?php

namespace App\Actions;

use TCG\Voyager\Actions\AbstractAction;

class Groups extends AbstractAction
{
    public function getTitle()
    {
        return 'Edit Estate';
    }

    public function getIcon()
    {
        return 'voyager-edit';
    }

    public function getPolicy()
    {
        return 'edit_estate';
    }

    public function getAttributes()
    {
        return [
            'class' => 'btn btn-sm btn-primary pull-left',
        ];
    }

    public function shouldActionDisplayOnDataType()
    {
        // show or hide the action button, in this case will show for posts model
        return $this->dataType->slug == 'groups';
    }

    public function getDefaultRoute()
    {
        return route('admin.groups.estate',array('id'=>  $this->data->{$this->data->getKeyName()}));
    }
}