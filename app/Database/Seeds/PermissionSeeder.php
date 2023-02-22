<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissionModel = new \App\Models\PermissionModel();

        $permissions = [
            ['name' =>  'list_users'],
            ['name' =>  'create_users'],
            ['name' =>  'edit_users'],
            ['name' =>  'delete_users'],
        ];

        foreach($permissions as $perm)
        {
            $permissionModel->protect(false)->insert($perm);
        }

        echo 'Permissoes criadas!';
    }
}
