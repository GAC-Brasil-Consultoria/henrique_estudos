<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Users extends BaseController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Lista de usuários'
        ];

        return view('Users/index', $data);
    }

    public function getUsers()
    {
        /*if(!$this->request->isAJAX())
            return redirect()->back();
        */

        $atributes = [
            'id',
            'name',
            'email',
            'active',
            'image'
        ];

        $users = $this->userModel->select($atributes)->findAll();

        $data = [];

        foreach($users as $user)
        {
            $data[] = [
                'image' => $user->image,
                'name' => esc($user->name),
                'email' => esc($user->email),
                'active' => $user->active == true ? 'Active' : '<span class="text-warning">Inactive</span>'
            ];
        }

        $retorno = [
            'data' => $data
        ];

        return $this->response->setJSON($retorno);
    }
}
