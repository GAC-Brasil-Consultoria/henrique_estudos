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
                'name' => anchor("users/show/$group->id", esc($group->name), 'title="Show '.$groupName.' group"'),
                'description' => esc($group->description),
                'show' => ($group->show == true ? '<i class="fa fa-eye text-secondary"></i>&nbsp;Show group' : '<i class="fa fa-eye-slash text-danger"></i>')
            ];
        }

        $retorno = [
            'data' => $data
        ];

        return $this->response->setJSON($retorno);
    }
}
