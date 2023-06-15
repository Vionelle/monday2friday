<?= $this->extend('layout_new')?>
<?= $this->section('content')?>
<div class="container">
    <div class="row">
        <div class="form-bayar mt-4 col-8">
            <h2 class="my-3">Form Bayar Pesanan</h2>
            <form action="<?= site_url('transaksi/submitBayar/' . $transaksi->id_transaksi) ?>" method="post" enctype="multipart/form-data">
                <!-- crsf agar form hanya dapat diakses di halaman ini -->
                <?= csrf_field(); ?>
                <input type="hidden" name="slug" id="" value="<?= $transaksi->id_transaksi; ?>">

                <div class=" form-group row">
                    <label for="username" class="col-sm-2 col-form-label">Pembeli</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="username" name="username" value="<?= (old('username')) ? old('username') : $model->username ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama" class="col-sm-2 col-form-label">Produk</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="nama" name="nama" value="<?= (old('nama')) ? old('nama') : $model->nama  ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="jumlah" class="col-sm-2 col-form-label">Jumlah Pembelian</label>
                    <div class="col-sm-10">
                        <input readonly type="number" class="form-control" id="jumlah" name="jumlah" value="<?= (old('jumlah')) ? old('jumlah') : $model->jumlah ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="total_harga" class="col-sm-2 col-form-label">Total Harga</label>
                    <div class="col-sm-10">
                        <input readonly type="number" class="form-control" id="total_harga" name="total_harga" value="<?= (old('total_harga')) ? old('total_harga') : $model->total_harga ?>">
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
                        <img src="/img/default.png" class="img-thumbnail img-preview">
                    </div>
                    <div class="col-sm-10">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input <?= ($validation->hasError('bukti_bayar')) ? 'is-invalid' : ''; ?>" id="bukti_bayar" name="bukti_bayar" onchange="previewImgBayar()">
                            <div class="invalid-feedback">
                                <?= $validation->getError('bukti_bayar'); ?>
                            </div>
                            <label class="custom-file-label" for="bukti_bayar"><?= $transaksi->bukti_bayar; ?></label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-success">Bayar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>