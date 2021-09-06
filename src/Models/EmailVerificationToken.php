<?php

namespace SweetScar\AuthIgniter\Models;

use CodeIgniter\Model;

class EmailVerificationToken extends Model
{
    protected $table = 'authigniter_email_verification_tokens';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['email', 'token'];
    protected $useTimestamps = true;
}
