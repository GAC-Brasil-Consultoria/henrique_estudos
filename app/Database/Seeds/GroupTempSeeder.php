<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class GroupTempSeeder extends Seeder
{
    public function run()
    {
        $groupModel = new \App\Models\GroupModel();

        $groups = [
            [
                'name' => 'Admin',
                'description' => 'Full control',
                'show' => false,
            ],
            [
                'name' => 'Customers',
                'description' => 'This group is designed only to customers see service orders',
                'show' => false,
            ],
            [
                'name' => 'Attendant',
                'description' => 'This group is designed only to customers see service orders',
                'show' => false,
            ]
        ];

        foreach($groups as $group)
        {
            $groupModel->insert($group);
        }

        echo "Groups created!";
    }
}
