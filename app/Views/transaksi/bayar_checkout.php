<?= $this->extend('layout_new')?>
<?= $this->section('content')?>
<?php
    $username = session()->get('username')
?>
<div class="container">
    <div class="row">
        <div class="form-bayar mt-4 col-8">
            <form action="<?= site_url('transaksi/submitCheckout') ?>" method="post" enctype="multipart/form-data">
                <!-- crsf agar form hanya dapat diakses di halaman ini -->
                <?= csrf_field(); ?>
                <div class=" form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Pembeli</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="username" name="username" value="<?= (old('username')) ? old('username') : $username ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Produk</label>
                    <div class="col-sm-10">
                        <?php foreach($cart->contents() as $value => $items): ?>
                        <input readonly type="text" class="form-control" id="nama" name="nama" value="<?= (old('nama')) ? old('nama') : $items['name'] . " (" . $items['qty'] . ") "  ?>">
                        <?php endforeach ?>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="total_harga" class="col-sm-2 col-form-label">Total Harga</label>
                    <div class="col-sm-10">
                        <input readonly type="number" class="form-control" id="total_harga" name="total_harga" value="<?= (old('total_harga')) ? old('total_harga') : $total ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="nama_bank" class="col-sm-2 col-form-label">Nama Bank</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('nama_bank')) ? 'is-invalid' : ''; ?>" id="nama_bank" name="nama_bank" autofocus value="<?= old('nama_bank'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('nama_bank'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="atas_nama" class="col-sm-2 col-form-label">Atas Nama</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control <?= ($validation->hasError('atas_nama')) ? 'is-invalid' : ''; ?>" id="atas_nama" name="atas_nama" autofocus value="<?= old('atas_nama'); ?>">
                        <div class="invalid-feedback">
                            <?= $validation->getError('atas_nama'); ?>
                        </div>
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="bukti_bayar" class="col-sm-2 col-form-label">Bukti Pembayaran</label>
                    <div class="col-sm-2">
                        <img src="<?= base_url('mtf/default.png')?>" class="img-thumbnail img-preview mb-3">
                    </div>
                    <div class="col-sm-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('bukti_bayar')) ? 'is-invalid' : ''; ?>" id="bukti_bayar" name="bukti_bayar" onchange="previewImgBayar()">
                            <div class="invalid-feedback">
                                <?= $validation->getError('bukti_bayar'); ?>
                            </div>
                            <label class="custom-file-label" for="bukti_bayar"><?= "" ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success mb-3">Bayar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>