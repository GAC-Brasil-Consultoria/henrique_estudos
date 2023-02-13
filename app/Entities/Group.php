<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class Group extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    protected $casts   = [];

    public function showStatus()
    {
        if($this->deleted_at != null)
        {
            $icon = '<span class="text-white">Deleted</span>&nbsp;<i class="fa fa-undo"></i>&nbsp;Undo';

            $btnUndo = anchor("groups/undodelete/$this->id", $icon, ['class' => 'btn btn-outline-danger btn-sm']);

            return $btnUndo;
        }
        //'<i class="fa fa-unlock text-success"></i>&nbsp;Active' : '<i class="fa fa-unlock text-warning"></i>&nbsp;Inactive'
        

        return $this->show == true ? '<i class="fa fa-eye text-secondary"></i>&nbsp;Show group' : '<i class="fa fa-eye-slash text-danger"></i>';
    }

}
