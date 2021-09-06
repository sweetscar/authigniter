<?php

namespace SweetScar\AuthIgniter\Models;

use CodeIgniter\Model;

class ResetPasswordToken extends Model
{
    protected $table = 'authigniter_reset_password_tokens';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['email', 'ip_address', 'user_agent', 'token'];
    protected $useTimestamps = true;
}
