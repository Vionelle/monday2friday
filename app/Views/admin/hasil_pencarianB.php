<form action="<?php echo base_url('admin/hasilcari')?>" method="GET">
    <div class="input-group mb-3">
        <input name="search" type="text" class="form-control" placeholder="Search..."/>
        <button class="btn btn-dark btn-lg" type="submit" id="button-addon2">Cari</button>
    </div>
</form>
<div class="card-header">
    <h6 class="mt-3">Hasil</h6>
</div>
<div class="card-body">
    <table class="table table-bordered mt-3">
        <thead>
            <th>Barang</th>
            <th>Gambar</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Size</th>
        </thead>
        <tbody>
        <?php
            if(count($dataS)>0) {
                foreach ($dataS as $barang) {
                    echo "<tr>";
                    echo "<td>" . $barang['nama'] . "</td>";
                    echo "<td>" . $barang['harga'] . "</td>";
                    echo "<td>" . $barang['stok'] . "</td>";
                    echo "<td>" . $barang['size'] . "</td>";
                    echo "</tr>";
                }
            }
            else {
                echo "Data tidak ditemukan";
            }
            ?>
        </tbody>
    </table>
</div>