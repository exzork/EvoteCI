<?php

namespace App\Models;

use CodeIgniter\Model;

class EventModel extends Model
{
    protected $table = "event";
    protected $allowedFields = ['kode_event', 'nama_event', 'deskripsi', 'foto_event', 'admin', 'waktu_mulai', 'waktu_selesai'];
}
