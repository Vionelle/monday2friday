<?php 
    $session = session();
    $success = $session->getFlashdata('success');
?>
<div class="card-header">
    <h6 class="mt-3">Laporan Transaksi</h6>
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
    <table class="table">
        <thead>
            <tr>
                <td>Id</td>
                <td>Barang</td?>
                <td>Pembeli</td>
                <td>Alamat</td>
                <td>Jumlah Pembelian</td>
                <td>Total Harga</td>
                <td>Status</td>
            </tr>
        </thead>
        <tbody>
            <?php foreach($model as $index=>$transaksi): ?>
                <tr>
                    <td><?= $transaksi->id ?></td>
                    <td><?= $transaksi->id_barang ?></td?>
                    <td><?= $transaksi->id_pembeli ?></td>
                    <td><?= $transaksi->alamat ?></td>
                    <td><?= $transaksi->jumlah ?></td>
                    <td><?= $transaksi->total_harga ?></td>
                    <td><?= $transaksi->status ?></td>
            </tr>
            <?php endforeach ?>
        </tbody>
    </table>
</div>