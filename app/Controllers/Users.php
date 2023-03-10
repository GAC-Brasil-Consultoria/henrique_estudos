<?php

namespace App\Controllers;

use App\Controllers\BaseController;

use App\Entities\User;
use function PHPUnit\Framework\isEmpty;

class Users extends BaseController
{
    private $userModel;
    private $groupUserModel;
    private $groupModel;

    public function __construct()
    {
        $this->userModel = new \App\Models\UserModel();
        $this->groupUserModel = new \App\Models\GroupUserModel();
        $this->groupModel = new \App\Models\GroupModel();
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
            'image',
            'deleted_at'
        ];

        $users = $this->userModel->select($atributes)->withDeleted(true)->orderBy('id', 'DESC')->findAll();

        $data = [];

        foreach($users as $user)
        {
            if($user->image != null)
            {
                //has image
                $image = [
                    'src' => site_url("users/image/$user->image"),
                    'class' => 'rounded-circle img-fluid',
                    'alt' => esc($user->name),
                    'width' => '50'
                ];
            }else
            {
                //no has image
                $image = [
                    'src' => site_url("resources/img/blankImg.png"),
                    'class' => 'rounded-circle img-fluid',
                    'alt' => 'User without Avatar',
                    'width' => '50'
                ];
            }

            $userName = esc($user->name);
            $data[] = [
                'image' => $user->image = img($image),
                'name' => anchor("users/show/$user->id", esc($user->name), 'title="Show '.$userName.' user"'),
                'email' => esc($user->email),
                'active' => $user->showStatus()
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

    public function add()
    {
        $user = new User();

        //dd($user);
        
        $data = [
            'title' => "Creating a new user ",
            'user' => $user
        ];

        return view('Users/add', $data);
    }

    public function insert()
    {
        if(!$this->request->isAJAX())
            return redirect()->back();
        
        $return['token'] = csrf_hash();

        $post = $this->request->getPost();

        $user = new User($post);
        
        if($this->userModel->protect(false)->save($user))
        {
            $btnAdd = anchor("users/add", 'Register new user', ['class' => 'btn btn-danger mt-2']);
            session()->setFlashdata('success', "Data saved! <br> $btnAdd");
            $return['id'] = $this->userModel->getInsertID();
            return $this->response->setJSON($return);
        }
        
        $return['error'] = 'Plese, check the errors below and try again';
        $return['errors_model'] = $this->userModel->errors();        

        return $this->response->setJSON($return);
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

    public function upload()
    {
        if(!$this->request->isAJAX())
            return redirect()->back();
        
        $return['token'] = csrf_hash();

        $validation = service('validation');

        $rules = [
            'img' => 'uploaded[img]|max_size[img,1024]|ext_in[img,png,jpg,jpeg,webp]',
        ];

        $messages = [   // Errors
            'img' => [
                'uploaded' => 'Please, choose a image',
                'ext_in' => 'The file must be png, jpg, jpeg or webp'
            ],
        ];

        $validation->setRules($rules, $messages);

        if($validation->withRequest($this->request)->run() == false)
        {
            $return['error'] = 'Plese, check the errors below and try again';
            $return['errors_model'] = $validation->getErrors();        

            return $this->response->setJSON($return);
        }

        $post = $this->request->getPost();

        
        
        $user = $this->getUser($post['id']);

        $img = $this->request->getFile('img');

        list($width, $heigth) = getimagesize($img->getPathname());

        if($width < "300" || $heigth <  "300")
        {
            $return['error'] = 'Plese, check the errors below and try again';
            $return['errors_model'] = ['minSize' => 'The image cannot be less than 300 x 300 pixels'];        

            return $this->response->setJSON($return);
        }

        $imgPath = $img->store('avatars');

        $imgPath = WRITEPATH . 'uploads/'.$imgPath;
        
        $this->editImg($imgPath, $user->id);
        
        $oldImg = $user->image;

        $user->image = $img->getName();
        $this->userModel->save($user);

        if($oldImg != null)
            $this->removeImg($oldImg);

        session()->setFlashdata('success', 'Avatar updated with success!');
        
        return $this->response->setJSON($return);
    }

    private function editImg(string $imgPath, int $id)
    {
        service('image')->withFile($imgPath)
            ->fit(300, 300, 'center')
            ->save($imgPath);

            \Config\Services::image('imagick')
            ->withFile($imgPath)
            ->text('Dev ambient', [
                'color'      => '#fff',
                'opacity'    => 0.5,
                'withShadow' => false,
                'hAlign'     => 'center',
                'vAlign'     => 'bottom',
                'fontSize'   => 10,
            ])
            ->save($imgPath);
    }

    private function removeImg(string $img)
    {
        $imgPath = WRITEPATH . 'uploads/avatars/'.$img;
        
        if(is_file($imgPath))
        unlink($imgPath);
    }
    
    
    public function changeImg(int $id = null)
    {
        $user = $this->getUser($id);

        $data = [
            'title' => "changing ".esc($user->name)." profile picture",
            'user' => $user
        ];

        return view('Users/change_img', $data);
    }

    public function image(string $img = null)
    {
        if($img != null)
        {
            $this->showFile('avatars', $img);
        }
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
            session()->setFlashdata('success', 'Data saved!');
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

    public function delete(int $id = null)
    {
        $user = $this->getUser($id);

        if($user->deleted_at != null)
        {
            return redirect()->back()->with('warning', "This user is already deleted");
        }

        if($this->request->getMethod() === 'post')
        {
            $this->userModel->delete($user->id);
            if($user->image != null)
            {
                $this->removeImg($user->image);
            }

            $user->image = null;
            $user->active = false;

            $this->userModel->protect(false)->save($user);

            return redirect()->to(site_url('users'))->with('success', "User $user->name deleted!");
        }

        $data = [
            'title' => "Deleting ".esc($user->name)."",
            'user' => $user
        ];

        return view('Users/delete', $data);

    }

    public function undodelete(int $id = null)
    {
        $user = $this->getUser($id);

        if($user->deleted_at == null)
        {
            return redirect()->back()->with('warning', "Only deleted users can be recovery");
        }

        $user->deleted_at = null;
        $user->active = true;

        $this->userModel->protect(false)->save($user);

        return redirect()->back()->with('success', "User $user->name restored");

    }

    public function groups(int $id = null)
    {
        $user = $this->getUser($id);

        $user->groups = $this->groupUserModel->getGroupsUsers($user->id, 5);
        $user->pager = $this->groupUserModel->pager;
        
        $data = [
            'title' => "Managing access groups from user ".esc($user->name),
            'user' => $user
        ];

        if(!empty($user->groups))
        {
            $existingGroups = array_column($user->groups, 'group_id');
            $data['avaliableGroups'] = $this->groupModel->where('id!=', 2)
                                                        ->whereNotIn('id', $existingGroups)
                                                        ->findAll();
        }
        else
        {
            $existingGroups = array_column($user->groups, 'group_id');
            $data['avaliableGroups'] = $this->groupModel->where('id!=', 2)
                                                        ->findAll();
        }

        return view('Users/groups', $data);
    }
}
