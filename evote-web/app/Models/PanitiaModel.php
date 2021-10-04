<?php namespace App\Models;

use CodeIgniter\Model;
class PanitiaModel extends Model{
    protected $table = "panitia";
    protected $allowedFields=['kode_panitia','npm_panitia','event','jabatan'];
}