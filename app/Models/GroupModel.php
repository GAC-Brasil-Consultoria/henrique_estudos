<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table            = 'groups';
    protected $returnType       = 'App\Entities\Group';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = ['name', 'description', 'show'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name'        => 'required|max_length[120]|is_unique[groups.name,id,{id}]',
        'description'     => 'required|max_length[240]',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'The name field is required',
            'max_length' => 'The name can be a maximum of 240 characters'
        ],
    ];

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];
}
