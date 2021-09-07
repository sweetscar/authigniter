<?php

namespace SweetScar\AuthIgniter\Models;

use CodeIgniter\Model;

class Login extends Model
{
    protected $table = 'authigniter_logins';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['login', 'user_id', 'ip_address', 'success'];
    protected $useTimestamps = true;
}
