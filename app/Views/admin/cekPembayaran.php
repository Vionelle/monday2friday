
<div class="container container-cekPembayaran">
    <div class="cek-bayar-container row">
        <div class="col-6">

            <h2>Cek Pembayaran</h2>
            <form action="<?php echo site_url('admin/prosesProduk/' . $model->id_transaksi) ?>" method="post" enctype="multipart/form-data">
                <!-- crsf agar form hanya dapat diakses di halaman ini -->
                <?= csrf_field(); ?>
                <input type="hidden" name="id" id="" value="<?= $model->id_transaksi; ?>">

                <div class=" form-group row">
                    <label for="id_pembeli" class="col-sm-3 col-form-label">Pembeli</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="id_pembeli" name="id_pembeli" value="<?= (old('id_pembeli')) ? old('id_pembeli') : $model->id_pembeli ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="nama" class="col-sm-3 col-form-label">Produk</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="nama" name="nama" value="<?= (old('nama')) ? old('nama') : $model->nama  ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="jumlah" class="col-sm-3 col-form-label">Jumlah Pembelian</label>
                    <div class="col-sm-10">
                        <input readonly type="number" class="form-control" id="jumlah" name="jumlah" value="<?= (old('jumlah')) ? old('jumlah') : $model->jumlah ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="metode_pembayaran" class="col-sm-3 col-form-label">Metode Pembayaran</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="metode_pembayaran" name="metode_pembayaran" value="<?= (old('metode_pembayaran')) ? old('metode_pembayaran') : $model->metode_pembayaran ?>">
                    </div>
                </div>
                <div class=" form-group row">
                    <label for="atas_nama" class="col-sm-3 col-form-label">Atas Nama</label>
                    <div class="col-sm-10">
                        <input readonly type="text" class="form-control" id="atas_nama" name="atas_nama" value="<?= (old('atas_nama')) ? old('atas_nama') : $model->atas_nama ?>">
                    </div>
                </div>
                <div class="label-akhir form-group row">
                    <label for="total_harga" class="col-sm-3 col-form-label">Total Harga</label>
                    <div class="col-sm-10">
                        <input readonly type="number" class="form-control" id="total_harga" name="total_harga" value="<?= (old('total_harga')) ? old('total_harga') : $model->total_harga ?>">
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <input class="btn btn-warning" name="submit" value="bukti salah" aria-label="halo" type="submit">
                        <input class="btn btn-primary" name="submit" value="bukti benar" type="submit">
                    </div>
                </div>
            </form>
        </div>
        <div class="col-6">
            <img class="img_bukti-bayar" style="max-width: 600px;" src="<?= base_url('img/'.$model->bukti_bayar)?>" alt="">
        </div>
    </div>
</div>