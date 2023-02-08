<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionsModel extends Model
{
    
    protected $table            = 'permissions';
    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\Permissions';
    protected $allowedFields    = [];    
    
}
