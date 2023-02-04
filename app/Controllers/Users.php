<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use function PHPUnit\Framework\isEmpty;

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
        if(!$this->request->isAJAX())
            return redirect()->back();
        

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

        return view('Users/edit', $data);
    }
    
    public function update()
    {
        if(!$this->request->isAJAX())
            return redirect()->back();
        
        $return['token'] = csrf_hash();

        $post = $this->request->getPost();

        
        
        $user = $this->getUser($post['id']);
        
        if(empty($post['password']))
        {
            unset($post['password']);
            unset($post['password_confirmation']);
        }
        
        $user->fill($post);        
        
        if($user->hasChanged() == false)
        {
            $return['info'] = "No data to update...";
            return $this->response->setJSON($return);
        }

        if($this->userModel->protect(false)->save($user))
        {
            return $this->response->setJSON($return);
        }
        
        $return['error'] = 'Plese, check the errors below and try again';
        $return['errors_model'] = $this->userModel->errors();        

        return $this->response->setJSON($return);
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
