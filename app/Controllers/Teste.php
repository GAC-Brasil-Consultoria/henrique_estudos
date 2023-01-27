<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\CorModel;

class Teste extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Sending data from Controller to view'
        ];

        return view('teste', $data);
    }

    public function minha()
    {
        $corModel = new \App\Models\CorModel();

        $data = [
            'Title' => 'Array of Colors',
            'colors' => $corModel->findAll()
        ];
        
        return view('minha', $data);
    }
}
