<?php namespace App\Models;

use CodeIgniter\Model;
class AdminModel extends Model{
    protected $table ="admin";
    protected $allowedFields = ['kode_admin','username_admin','email_admin','password_admin'];
}