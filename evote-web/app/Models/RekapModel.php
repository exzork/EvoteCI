<?php

namespace App\Models;

use CodeIgniter\Model;

class RekapModel extends Model
{
    protected $table = "rekap";
    protected $allowedFields = ['kode_rekap', 'npm_pemilih', 'foto_ktm', 'foto_rekap', 'event', 'tanggal_pilih', 'valid'];
}
