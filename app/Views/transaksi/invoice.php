<html>
    <head>
        <style>
            table{
                border-collapse: collapse;
                width: 100%;
            }
            td, th{
                border: 1px solid #000000;
                text-align: center;
            }
        </style>    
    </head>
    <body>
        <!-- <div class="row">
            <div class="col-6">
                <div style="font-size:48px; color:'#dddddd' "><i>Invoice</i></div>
            </div>
            <div class="col-6">
                <img src="">
            </div>
        </div> -->
        <div style="font-size:48px; color:'#dddddd' "><i>Invoice</i></div>
        <p>
            <i>Monday to Friday Store<i><br>
            Jakarta, Indonesia<br>
            Jl. Lobak III, Pulo, Kebayoran Baru<br>
            081770785745
        </p><hr>
        <p>
            Pembeli: <?= $pembeli->username ?><br>
            Alamat: <?= $transaksi->alamat ?><br>
            No. Transaksi: <?= $transaksi->id ?><br>
            Tanggal: <?= date('Y-m-d', strtotime($transaksi->created_date)) ?>
        </p>
        <table cellpadding="3">
            <tr>
                <th><strong>Barang</strong></th>
                <th><strong>Harga Satuan</strong></th>
                <th><strong>Jumlah</strong></th>
                <th><strong>Ongkir</strong></th>
                <th><strong>Total Harga</strong></th>
            </tr>
            <tr>
                <td><?= $barang->nama ?></td>
                <td><?= "Rp. ".number_format($barang->harga,2,',','.') ?></td>
                <td><?= $transaksi->jumlah ?></td>
                <td><?= "Rp. ".number_format($transaksi->ongkir,2,',','.') ?></td>
                <td><?= "Rp. ".number_format($transaksi->total_harga,2,',','.') ?></td>
            </tr>
        </table>
    </body>
</html>