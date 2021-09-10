<?php

namespace SweetScar\AuthIgniter\Models;

use CodeIgniter\Model;

class UserGroup extends Model
{
    protected $table = 'authigniter_user_groups';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['user_id', 'group_id'];
    protected $useTimestamps = true;
    protected $validationRules    = [
        'user_id' => 'required',
        'group_id' => 'required',
    ];
    protected $validationMessages = [];
    protected $skipValidation     = false;
}
