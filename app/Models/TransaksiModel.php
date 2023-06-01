<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primarykey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id','id_barang','id_pembeli','jumlah','total_harga','alamat','ongkir','status'
        ,'created_by','created_date','updated_by','updated_date'
    ];
    protected $returnType = 'App\Entities\Transaksi';
    protected $useTimestamps = false;
}