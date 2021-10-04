<?php

namespace App\Models;

use CodeIgniter\Model;

class CalonModel extends Model
{
    protected $table = "calon";
    protected $allowedFields = ['kode_calon', 'npm_ketua', 'npm_wakil', 'foto_calon', 'pesan', 'pem', 'panitia', 'jumlah'];
}
