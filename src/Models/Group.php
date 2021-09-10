<?php

namespace SweetScar\AuthIgniter\Models;

use CodeIgniter\Model;

class Group extends Model
{
    protected $table = 'authigniter_groups';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'name' => 'required|alpha_dash|is_unique[authigniter_groups.name]|min_length[3]|max_length[255]',
        'description' => 'max_length[255]',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
