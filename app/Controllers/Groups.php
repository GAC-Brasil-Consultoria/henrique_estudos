<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Entities\Group;

class Groups extends BaseController
{

    private $groupModel;

    public function __construct()
    {
        $this->groupModel = new \App\Models\GroupModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Listing system groups access'
        ];

        return view('Groups/index', $data);
    }

    public function getGroups()
    {
        if(!$this->request->isAJAX())
            return redirect()->back();
        

        $atributes = [
            'id',
            'name',
            'description',
            'show',
            'deleted_at'
        ];

        $groups = $this->groupModel->select($atributes)->withDeleted(true)->orderBy('id', 'DESC')->findAll();
        
        $data = [];

        foreach($groups as $group)
        {
            
            $groupName = esc($group->name);
            $data[] = [
                'name' => anchor("groups/show/$group->id", esc($group->name), 'title="Show '.$groupName.' group"'),
                'description' => esc($group->description),
                'show' => $group->showStatus()
            ];
        }

        $retorno = [
            'data' => $data
        ];

        return $this->response->setJSON($retorno);
    }

    private function getGroupByID(int $id = null)
    {
        if(!$id || !$group = $this->groupModel->withDeleted(true)->find($id))
        {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Group $id not found");
        }

        return $group;
    }

    public function show(int $id = null)
    {
        $group = $this->getGroupByID($id);



        $data = [
            'title' => "Detailing group ".esc($group->name),
            'group' => $group
        ];

        return view('groups/show', $data);
    }

    public function edit(int $id = null)
    {
        $group = $this->getGroupByID($id);

        if($group->id < 3)
            return redirect()->back()->with('info', 'Your group '.esc($group->name).' cannot be edited');

        $data = [
            'title' => "Editing group ".esc($group->name),
            'group' => $group
        ];

        return view('Groups/edit', $data);
    }

    public function update()
    {
        if(!$this->request->isAJAX())
            return redirect()->back();
        
        $return['token'] = csrf_hash();

        $post = $this->request->getPost();

        
        
        $group = $this->getGroupByID($post['id']);
        
        $group->fill($post);        
        
        if($group->hasChanged() == false)
        {
            $return['info'] = "No data to update...";
            return $this->response->setJSON($return);
        }

        if($this->groupModel->protect(false)->save($group))
        {
            session()->setFlashdata('sucess', 'Data saved!');
            return $this->response->setJSON($return);
        }
        
        $return['error'] = 'Plese, check the errors below and try again';
        $return['errors_model'] = $this->groupModel->errors();        
        
        return $this->response->setJSON($return);
    }

    public function undodelete(int $id = null)
    {
        $group = $this->getGroupByID($id);

        if($group->deleted_at == null)
        {
            return redirect()->back()->with('warning', "Only deleted groups can be recovery");
        }

        $group->deleted_at = null;
        $group->active = true;

        $this->groupModel->protect(false)->save($group);

        return redirect()->back()->with('success', "group $group->name restored");

    }
}
