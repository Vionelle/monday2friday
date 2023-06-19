<?= $this->extend('layout_new')?>
<?= $this->section('content')?>
<div class="beli-container container">
    <div class="row transaksi-container">
        <h2>Satu langkah lagi untuk menyelesaikan transaksi</h2>
        <p class="p-headings">Berikut adalah detail barang yang telah dibeli. Silahkan klik tombol bayar untuk menyelesaikan pemesanan</p>

        <table class="table-detail-transaksi table ">
            <thead>
                <tr>
                    <th>Id Transaksi</th>
                    <th>Id Pembeli</th>
                    <th>Alamat</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><?= $transaksi->id_transaksi; ?></td>
                    <td><?= $transaksi->id_pembeli; ?></td>
                    <td><?= $transaksi->alamat; ?></td>
                    <td><?= $transaksi->jumlah; ?></td>
                    <td><?= $transaksi->total_harga; ?></td>
                    <td><?= $transaksi->status; ?></td>
                </tr>
            </tbody>
        </table>

        <div class="detail-transaksi">
            <p>Id Transaksi : <b><?= $transaksi->id_transaksi; ?></b></p>
            <p>Barang : <b><?= $transaksi->id_pembeli; ?></b></p>
            <p>Alamat : <b><?= $transaksi->alamat; ?></b></p>
            <p>Jumlah : <b><?= $transaksi->jumlah; ?></b></p>
            <p>Total Harga : <b><?= $transaksi->total_harga; ?></b></p>
            <p>Pembeli : <b><?= $transaksi->status; ?></b></p>
        </div>
    </div>
    <div class="link-order">
        <a href="<?= site_url('transaksi/bayar/' . $transaksi->id_transaksi); ?>" class="btn btn-success mb-3">Bayar</a>
    </div>
</div>
<?= $this->endSection()?>