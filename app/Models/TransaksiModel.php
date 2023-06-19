<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';
    protected $useAutoIncrement = false;
    protected $allowedFields = [
        'id_transaksi','id_barang','id_pembeli','jumlah','total_harga','kode_resi','alamat','ongkir','status', 'bukti_bayar', 'metode_pembayaran', 'atas_nama'
        ,'created_date','updated_date'
    ];
    protected $returnType = 'App\Entities\Transaksi';
    protected $useTimestamps = false;

    public function getTransaction($id_transaksi = false)
    {
        if ($id_transaksi == false) {
            return $this->findAll();
        }

        return $this->where(['id_transaksi' => $id_transaksi])->first();
    }
}