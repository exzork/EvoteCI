<?php

namespace App\Models;

use CodeIgniter\Model;

class TokenModel extends Model
{
    protected $primaryKey = 'token';
    protected $table = "tokens";
    protected $allowedFields = ['token', 'email', 'status'];
}
