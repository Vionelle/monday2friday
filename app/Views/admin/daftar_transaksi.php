<?php 
    $session = session();
    $success = $session->getFlashdata('success');
    $gagal = $session->getFlashdata('gagal');
?>
<div class="card-header">
    <h6 class="mt-3">Daftar Transaksi</h6>
</div>
<div class="card-body">
<?php if($success != null): ?>
    <div class ="alert alert-success" role="alert">
        <h4 class="alert-heading">Success</h4>
        <hr>
        <p class = "mb-0">
            <?php foreach($success as $s){
                echo $s.'<br';
            }
            ?>
        </p>
    </div>
    <?php endif ?>
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
    <br>
    
    <table class="table">
        <thead>
            <tr>
                <td>Id</td>
                <td>Barang</td?>
                <td>Pembeli</td>
                <td>Alamat</td>
                <td>Jumlah Pembelian</td>
                <td>Harga</td>
                <td>Action</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($model as $index=>$transaksi): ?>
                <tr>
                    <td><?= $transaksi->id_transaksi ?></td>
                    <td><?= $transaksi->id_barang ?></td?>
                    <td><?= $transaksi->id_pembeli ?></td>
                    <td><?= $transaksi->alamat ?></td>
                    <td><?= $transaksi->jumlah ?></td>
                    <td><?= $transaksi->total_harga ?></td>
                    <td>
                        <a href="<?= site_url('admin/viewtransaksi/'.$transaksi->id_transaksi) ?>"
                        class="btn btn-primary">View</a>
                        <a href="<?= site_url('admin/batal/' . $transaksi->id_transaksi); ?>" class="btn btn-danger">Batal</a>
                    </td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>