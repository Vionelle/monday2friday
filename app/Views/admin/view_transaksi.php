<?php 
    $session = session();
    $success = $session->getFlashdata('success');
    $gagal = $session->getFlashdata('gagal');
?>

<?php if (session()->getFlashdata('pesan')) : ?>
    <div class="alert alert-success" role="alert">
        <?= session()->getFlashdata('pesan'); ?>
    </div>
<?php endif; ?>
<?php if (session()->getFlashdata('gagal')) : ?>
    <div class="alert alert-danger" role="alert">
        <?= session()->getFlashdata('gagal'); ?>
    </div>
<?php endif; ?>

<div class="card-header">
    <h6 class="mt-3"></h6>
</div>
<div class="card-body">
    <table class="table">
        <tr>
            <td>Barang</td>
            <td><?= $transaksi->nama ?></td>
        </tr>
        <tr>
            <td>Pembeli</td>
            <td><?= $transaksi->username ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td><?= $transaksi->alamat ?></td>
        </tr>
        <tr>
            <td>Jumlah</td>
            <td><?= $transaksi->jumlah ?></td>
        </tr>
        <tr>
            <td>Status</td>
            <td><?= $transaksi->status ?></td>
        </tr>
        <tr>
            <td>Total Harga</td>
            <td><?= $transaksi->total_harga ?></td>
        </tr>
    </table>

    <!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button> -->

<!-- Modal -->
<!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div> -->

    <!-- Modal -->
        <div class="modal fade" id="modalInputResi">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal Title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="<?= site_url('admin/simpanResi/' . $transaksi->id_transaksi) ?>" method="post" enctype="multipart/form-data">
                            <!-- crsf agar form hanya dapat diakses di halaman ini -->
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id_transaksi" id="" value="<?= $transaksi->id_transaksi; ?>">

                            <div class="form-group row">
                                <label for="nama" class="col-sm-3 col-form-label">Barang</label>
                                <div class="col-sm-10">
                                    <input readonly type="text" class="form-control <?= ($validation->hasError('nama')) ? 'is-invalid' : ''; ?>" id="nama" name="nama" value="<?= (old('nama')) ? old('nama') : $transaksi->nama  ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('nama'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="username" class="col-sm-3 col-form-label">Pembeli</label>
                                <div class="col-sm-10">
                                    <input readonly type="text" class="form-control <?= ($validation->hasError('username')) ? 'is-invalid' : ''; ?>" id="username" name="username" value="<?= (old('username')) ? old('username') : $transaksi->username ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('username'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="alamat" class="col-sm-3 col-form-label">Alamat</label>
                                <div class="col-sm-10">
                                    <input readonly type="text" class="form-control <?= ($validation->hasError('alamat')) ? 'is-invalid' : ''; ?>" id="alamat" name="alamat" value="<?= (old('alamat')) ? old('alamat') : $transaksi->alamat ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('alamat'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="jumlah" class="col-sm-3 col-form-label">Jumlah</label>
                                <div class="col-sm-10">
                                    <input readonly type="number" class="form-control <?= ($validation->hasError('jumlah')) ? 'is-invalid' : ''; ?>" id="jumlah" name="jumlah" value="<?= (old('jumlah')) ? old('jumlah') : $transaksi->jumlah ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('jumlah'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="total_harga" class="col-sm-3 col-form-label">Total Harga</label>
                                <div class="col-sm-10">
                                    <input readonly type="number" class="form-control <?= ($validation->hasError('total_harga')) ? 'is-invalid' : ''; ?>" id="total_harga" name="total_harga" value="<?= (old('total_harga')) ? old('total_harga') : $transaksi->total_harga ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('total_harga'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="kode_resi" class="col-sm-3 col-form-label">Kode Resi</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control <?= ($validation->hasError('kode_resi')) ? 'is-invalid' : ''; ?>" autofocus id="kode_resi" name="kode_resi" value="<?= (old('kode_resi')) ? old('kode_resi') : $transaksi->kode_resi ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('kode_resi'); ?>
                                    </div>
                                </div>
                            </div>
                            <div class=" form-group row">
                                <label for="status" class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-10">
                                    <input readonly type="text" class="form-control <?= ($validation->hasError('status')) ? 'is-invalid' : ''; ?>" id="status" name="status" value="<?= (old('status')) ? old('status') : $transaksi->status ?>">
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('status'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" aria-label="Close">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div> -->
                </div>
            </div>
        </div>
    <!-- End Modal -->
    <div style="float:right">
        
    <?php if ($transaksi->status == 'MENUNGGU KONFIRMASI PEMBAYARAN') { ?>
        <a href="<?= site_url('admin/cekPembayaran/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Cek Pembayaran</a>
    <?php } ?>
    <?php if ($transaksi->status == 'BUKTI PEMBAYARAN SALAH') { ?>
        <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
    <?php } ?>
    <?php if ($transaksi->status == 'TRANSAKSI DIPROSES') { ?>
        <!-- <a href="<?= site_url('admin/inputResi/' . $transaksi->id_transaksi); ?>" data-toggle="modal" data-target="#modal-inputResi" class="btn btn-info">Input Resi</a> -->
        <!-- <a type="button" class="btn btn-success mb-2" data-toggle="modal" data-target="#addModal">Input Resi</a> -->
        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#modalInputResi">Input Resi</button>
    <?php } ?>
    </div>
</div>