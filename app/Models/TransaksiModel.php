<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primarykey = 'id';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id','id_barang','id_pembeli','jumlah','total_harga','kode_resi','alamat','ongkir','status', 'bukti_bayar', 'metode_pembayaran'
        ,'created_date','updated_date'
    ];
    protected $returnType = 'App\Entities\Transaksi';
    protected $useTimestamps = false;

    public function getTransaction($id_transaksi = false)
    {
        if ($id_transaksi == false) {
            return $this->findAll();
        }

        return $this->where(['id' => $id_transaksi])->first();
    }
}