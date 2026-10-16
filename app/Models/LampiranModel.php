<?php

namespace App\Models;

use CodeIgniter\Model;

class LampiranModel extends Model
{
    protected $table            = 'lampiran';
    protected $primaryKey       = 'id_lampiran';
    protected $returnType       = 'array';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'id_aktifitas',
        'user_id',
        'nama_dokumen',
        'nama_file',
        'file_path',
        'keterangan',
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
