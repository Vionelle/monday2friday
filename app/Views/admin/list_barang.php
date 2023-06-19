<?php
    $session = session();
    $errors = $session->getFlashdata('errors');
?>
<div class="card-header">
    <div class="row">
        <div class="col-3">
            <h6 class="mt-3">Daftar Barang</h6>
        </div>
        <div class="col-9 text-end">
            <a href="<?php echo site_url('admin/v_tambahbarang')?>" style="float:right" class="btn btn-success">Tambah Barang</a>
        </div>
    </div>
</div>
<div class="card-body">
    <?php if($errors != null): ?>
        <div class ="alert alert-warning" role="alert">
            <h4 class="alert-heading">Terjadi Kesalahan</h4>
            <hr>
            <p class = "mb-0">
                <?php 
                    foreach($errors as $err){
                        echo $err.'<br';
                    }
                ?>
            </p>
        </div>
    <?php endif ?>
    <table class="table table-bordered mt-3">
        <thead>
            <th>No</th>
            <th>Barang</th>
            <th>Gambar</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Size</th>
            <th>Aksi</th>
        </thead>
        <tbody>
            <?php foreach($b as $index => $barang): ?>
                <tr>
                    <td><?= ($index+1) ?></td>
                    <td><?= $barang->nama ?></td>
                    <td><img class="img-fluid" width="150px" alt="gambar" src="<?= base_url('uploads/'.$barang->gambar)?>"></td>
                    <td><?= "Rp. ".number_format($barang->harga,2,',','.') ?></td>
                    <td><?=$barang->stok ?></td>
                    <td><?=$barang->size ?></td>
                    <td>
                        <a href="<?= site_url('admin/viewbarang/'.$barang->id_barang)?>" class="btn btn-primary">View</a>
                        <a href="<?= site_url('admin/updatebarang/'.$barang->id_barang)?>" class="btn btn-success">Update</a>
                        <a href="<?= site_url('admin/deletebarang/'.$barang->id_barang)?>" class="btn btn-danger">Delete</a>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <div style="float:right">
        <?= $data['pager']->links('default','custom_pagination') ?>
    </div>
</div>