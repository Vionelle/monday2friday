<div class="card-header">
    <h6 class="mt-3">Transaksi</h6>
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
            <td>Jumlah</td>
            <td><?= $transaksi->status ?></td>
        </tr>
        <tr>
            <td>Total Harga</td>
            <td><?= $transaksi->total_harga ?></td>
        </tr>
    </table>
    <div style="float:right">
        <a href="<?= site_url('admin/invoice/'.$transaksi->id) ?>" class="btn btn-success">Kirim Invoice</a>
    </div>
</div>