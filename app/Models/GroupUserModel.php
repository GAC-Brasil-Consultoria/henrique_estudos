<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupUserModel extends Model
{
    protected $table            = 'groups_users';
    protected $returnType       = 'object';
    protected $allowedFields    = ['group_id', 'user_id'];

    public function getGroupsUsers(int $user_id, int $qtt)
    {
        $atributes = [
            'groups_users.id',
            'groups.id as group_id',
            'groups.name',
            'groups.description'
        ];

        return $this->select($atributes)
                    ->join('groups', 'groups.id = groups_users.group_id')
                    ->join('users', 'users.id = groups_users.user_id')
                    ->where('groups_users.user_id', $user_id)
                    ->groupBy('groups.name')
                    ->paginate($qtt);
    }
}
