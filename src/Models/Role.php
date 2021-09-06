<?php

namespace SweetScar\AuthIgniter\Models;

use CodeIgniter\Model;

class Role extends Model
{
    protected $table = 'authigniter_roles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = false;
}
