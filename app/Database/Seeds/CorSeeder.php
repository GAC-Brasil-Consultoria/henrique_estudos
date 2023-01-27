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
                'name' => 'Amarela'
            ],
            [
                'name' => 'Azul'
            ],
            [
                'name' => 'Vermelha'
            ],
            [
                'name' => 'Verde'
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
