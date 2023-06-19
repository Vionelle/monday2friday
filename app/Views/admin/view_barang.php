<div class="card-header">
    <h3>View Barang</h3>
</div>
<div class="card-body">
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="card-body">
                    <img class="img-fluid" alt="image" src="<?= base_url('uploads/'.$barang->gambar)?>"/>
                </div>
            </div>
        </div>
        <div class="col-9">
            <h1 class="text-success"><?= $barang->nama?></h1>
            <h4>ID: <?= $barang->id_barang ?></h4>
            <h4>Harga: <?= "Rp. ".number_format($barang->harga,2,',','.') ?></h4>
            <h4>Size: <?= $barang->size ?></h4>
            <h4>Stok: <?= $barang->stok ?></h4>
        </div>
    </div>
</div>