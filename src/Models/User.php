<?php

namespace SweetScar\AuthIgniter\Models;

use CodeIgniter\Model;
use SweetScar\AuthIgniter\Entities\User as UserEntity;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = UserEntity::class;
    protected $useSoftDeletes = true;
    protected $allowedFields = ['id', 'email', 'username', 'password', 'active', 'email_is_verified'];
    protected $useTimestamps = true;
}
