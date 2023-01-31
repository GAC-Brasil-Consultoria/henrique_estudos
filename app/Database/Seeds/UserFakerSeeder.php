<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserFakerSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel();

        $faker = \Faker\Factory::create();
        
        $howManyUsers = 50;

        $usersPush = [];

        for($i = 0; $i < $howManyUsers; $i++)
        {
            array_push($usersPush,[
                'name' => $faker->unique()->name,
                'email' => $faker->unique()->email,
                'password_hash' => '123456',
                'ativo' => true
            ]);

            echo '<pre>';
            print_r($usersPush);
        }

        $userModel->skipValidation(true)->protect(true)->insertBatch($usersPush);

        echo "$howManyUsers criados com sucesso!";
    }
}
