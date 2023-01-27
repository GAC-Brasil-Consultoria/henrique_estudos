<?php

namespace App\Models;

use CodeIgniter\Model;

class CorModel extends Model
{
    protected $table            = 'cores';
    protected $primaryKey       = 'id';
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $allowedFields    = ['name'];    
   
}
