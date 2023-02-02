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
            $userName = esc($user->name);
            $data[] = [
                'image' => $user->image,
                'name' => anchor("users/show/$user->id", esc($user->name), 'title="Show '.$userName.' user"'),
                'email' => esc($user->email),
                'active' => $user->active == true ? '<i class="fa fa-unlock text-sucess"></i>&nbsp;Active' : '<i class="fa fa-unlock text-warning"></i>&nbsp;Inactive'
            ];
        }

        $retorno = [
            'data' => $data
        ];

        return $this->response->setJSON($retorno);
    }

    public function show(int $id = null)
    {
        $user = $this->getUser($id);



        $data = [
            'title' => "Detailing user ".esc($user->name),
            'user' => $user
        ];

        return view('Users/show', $data);
    }

    public function edit(int $id = null)
    {
        $user = $this->getUser($id);

        $data = [
            'title' => "Editing user ".esc($user->name),
            'user' => $user
        ];

        return view('Users/show', $data);
    }

    private function getUser(int $id = null)
    {
        if(!$id || !$user = $this->userModel->withDeleted(true)->find($id))
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("User $id not found");
        }

        return $user;
    }
}
