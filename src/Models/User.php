<?php

namespace SweetScar\AuthIgniter\Models;

use CodeIgniter\Model;
use SweetScar\AuthIgniter\Entities\User as UserEntity;

class User extends Model
{
    protected $user;

    public function __construct()
    {
        $this->user = new UserEntity();
    }
}
