<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserFakerSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel();

        $faker = \Faker\Factory::create();
        
        $howManyUsers = 500;

        $usersPush = [];

        for($i = 0; $i < $howManyUsers; $i++)
        {
            array_push($usersPush,[
                'name' => $faker->unique()->name,
                'email' => $faker->unique()->email,
                'password_hash' => '123456',
                'active' => $faker->numberBetween(0,1)
            ]);
        }

        $userModel->skipValidation(true)->protect(false)->insertBatch($usersPush);

        echo "$howManyUsers criados com sucesso!";
    }
}
