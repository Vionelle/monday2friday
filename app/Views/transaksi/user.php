<?= $this->extend('layout_new')?>
<?= $this->section('content')?>

<div class="user-transaksi-container">
    <div class="row">
        <h2 class="text-center">List Transaksi <?= $username; ?></h2>
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

        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Pembeli</th>
                    <th>Alamat</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <!-- bikin sesuai dengan id user -->
                <?php $i = 1; ?>
                <?php foreach ($model as $index => $transaksi) : ?>
                    <tr>
                        <td><?= $i++; ?></td>
                        <td><?= $transaksi->id_barang; ?></td>
                        <td><?= $transaksi->id_pembeli; ?></td>
                        <td><?= $transaksi->alamat; ?></td>
                        <td><?= $transaksi->jumlah; ?></td>
                        <td><?= $transaksi->total_harga; ?></td>
                        <td><?= $transaksi->status; ?></td>
                        <td class="action-list-transaksi">
                            <?php if ($transaksi->status == 'BELUM BAYAR') { ?>
                                <a href="<?= site_url('transaksi/bayar/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Bayar</a>
                                <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                                <a href="<?= site_url('transaksi/batal/' . $transaksi->id_transaksi); ?>" class="btn btn-danger">Batal</a>
                                <!-- <form action="/transaksi/delete/<?= $transaksi->id_transaksi = isset($transaksi->id_transaksi) ? $transaksi->id_transaksi : ''; ?>" method="post" class="d-inline">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="_method" value="DELETE">
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('apakah anda yakin?')">Batal</button>
                                </form> -->
                            <?php } ?>
                            <?php if ($transaksi->status == 'MENUNGGU KONFIRMASI PEMBAYARAN') { ?>
                                <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                            <?php } ?>
                            <?php if ($transaksi->status == 'DIKIRIM') { ?>
                                <a href="<?= site_url('lacakResi/' . $transaksi->id_transaksi); ?>" class="btn btn-success">Lacak Resi</a>
                            <?php } ?>
                            <?php if ($transaksi->status == 'BUKTI PEMBAYARAN SALAH') { ?>
                                <a href="<?= site_url('transaksi/bayar/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Bayar</a>
                                <a href="<?= site_url('transaksi/invoice/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Invoice</a>
                            <?php } ?>

                            <?php if ($transaksi->status == 'PRODUK SEDANG DIANTAR') { ?>
                                <a href="<?= site_url('transaksi/lacakResi/' . $transaksi->id_transaksi); ?>" class="btn btn-info">Lacak Resi</a>
                                <a href="<?= site_url('transaksi/selesai/' . $transaksi->id_transaksi); ?>" class="btn btn-primary">Pesanan Sampai</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
        <div style='margin-top: 10px;'>
            <?= $pager->links() ?>
        </div>
    </div>
</div>

<?= $this->endSection(); ?>