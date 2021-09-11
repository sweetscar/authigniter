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
}
