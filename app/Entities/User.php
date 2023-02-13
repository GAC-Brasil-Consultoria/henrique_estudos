<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class User extends Entity
{
    
    protected $dates   = ['created_at', 'updated_at', 'deleted_at'];
    
    public function showStatus()
    {
        if($this->deleted_at != null)
        {
            $icon = '<span class="text-white">Deleted</span>&nbsp;<i class="fa fa-undo"></i>&nbsp;Undo';

            $btnUndo = anchor("users/undodelete/$this->id", $icon, ['class' => 'btn btn-outline-danger btn-sm']);

            return $btnUndo;
        }
        //'<i class="fa fa-unlock text-success"></i>&nbsp;Active' : '<i class="fa fa-unlock text-warning"></i>&nbsp;Inactive'
        

        return $this->active == true ? '<i class="fa fa-unlock text-success"></i>&nbsp;Active' :
                                        '<i class="fa fa-lock text-warning"></i>&nbsp;Inactive';
    }
    
}
