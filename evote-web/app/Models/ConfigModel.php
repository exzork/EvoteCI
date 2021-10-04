<?php namespace App\Models;

use CodeIgniter\Model;
class ConfigModel extends Model{
    protected $table = "configs";
    protected $allowedFields = ['universitas'];
}