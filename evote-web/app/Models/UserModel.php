<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = "user";
    protected $allowedFields = ['npm', 'nama_user', 'email_user', 'password_user', 'type'];
    // protected $primaryKey = 'npm';
}
