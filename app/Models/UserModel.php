<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';


    protected $primaryKey       = 'id';
    protected $returnType       = 'App\Entities\User';
    protected $useSoftDeletes   = true;
    protected $allowedFields    = [
        'name',
        'email',
        'password',
        'reset_hash',
        'reset_hash',
        'reset_expires_date',
        'image',
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules = [
        'name'     => 'required|min_length[3]|max_length[120]',
        'email'        => 'required|max_length[120]|valid_email|is_unique[users.email]',
        'password'     => 'required|min_length[6]',
        'password_confirmation' => 'required_with[password]|matches[password]',
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'The name field is required',
            'min_length' => 'The name need at least 3 carachters',
            'max_length' => 'The name can be a maximum of 120 characters'
        ],
        'email' => [
            'required' => 'The email field is required',
            'max_length' => 'The name can be a maximum of 120 characters',
            'is_unique' => 'Sorry. That email has already been taken. Please choose another.',
        ],
        'password_confirmation' => [
            'required_with' => 'Please, confirme your password',
            'matches' => 'The passwords do not match',
        ]
    ];

    // Callbacks
    protected $beforeInsert   = ['hashPassword'];
    protected $beforeUpdate   = ['hashPassword'];

    protected function hashPassword(array $data)
    {
        if (isset($data['data']['password'])) {

            $data['data']['password_hash'] = password_hash($data['data']['password'], PASSWORD_DEFAULT);
            unset($data['data']['password']);
            unset($data['data']['password_confirmation']);
        }        

        return $data;
    }
}
