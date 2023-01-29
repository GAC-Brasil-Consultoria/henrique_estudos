<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CorSeeder extends Seeder
{
    public function run()
    {
        $corModel = new \App\Models\CorModel();

        $cores = [
            [
                'name' => 'Amarela',
                'description' => 'Color description'
            ],
            [
                'name' => 'Azul',
                'description' => 'Color description'
            ],
            [
                'name' => 'Vermelha',
                'description' => 'Color description'
            ],
            [
                'name' => 'Verde',
                'description' => 'Color description'
            ],
        ];

        //dd($cores);

        foreach($cores as $cor)
        {
            $corModel->insert($cor);
        }

        echo 'Cores inseridas com sucesso!';
    }
}
