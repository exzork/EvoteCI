<?php

namespace App\Models;

use CodeIgniter\Model;

class IPBlockedModel extends Model
{
    protected $primaryKey = 'ip_address';
    protected $table = "ipblocked";
    protected $allowedFields = ['ip_address', 'blocked_time', 'times'];
}
