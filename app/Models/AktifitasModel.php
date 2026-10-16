<?php

namespace App\Models;

use CodeIgniter\Model;

class AktifitasModel extends Model
{
    protected $table = 'aktifitas';
    protected $primaryKey = 'id_aktifitas';
    protected $returnType = 'array';

    protected $allowedFields = [
        'user_id',
        'tanggal',
        'uraian_aktifitas',
        'pembelajaran',
        'kendala'
    ];

    protected $useTimestamps = true;
}