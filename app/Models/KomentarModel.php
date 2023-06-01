<?php

namespace App\Models;

use CodeIgniter\Model;

class KomentarModel extends Model
{
    protected $table = 'komentar';
    protected $primarykey = 'id';
    protected $allowedFields = [
        'id_barang','id_user','komentar','created_by','created_date','updated_by','updated_date'
    ];
    protected $returnType = 'App\Entities\Komentar';
    protected $useTimestamps = false;
}