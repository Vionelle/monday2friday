<?= $this->extend('layout_new')?>
<?= $this->section('content')?>

<div class="container">
    <div class="row">
        <div class="lacak-pesanan-heading">
            <h2 class="text-center">Lacak Resi</h2>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-8">
            <p>Berikut adalah kode resi anda : <?= $transaksi->kode_resi; ?></p>
            <div id="resi_status"></div>
            <div id="resi_posisi"></div>
            <div id="resi_result"></div>
        </div>
    </div>
</div>

<!-- <div class="col-md-8">
    <h1>STATUS PENGIRIMAN</h1>
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th scope="row">STATUS</th>
                <td>`+ resi.summary.status +`</td>
            </tr>
            <tr>
                <th scope="row">LAYANAN</th>
                <td>`+ resi.summary.service +`</td>
            </tr>
            <tr>
                <th scope="row">PENGIRIM</th>
                <td>`+ resi.detail.shipper +`</td>
            </tr>
            <tr>
                <th scope="row">ASAL</th>
                <td>`+ resi.detail.origin +`</td>
            </tr>
            <tr>
                <th scope="row">PENERIMA</th>
                <td>`+ resi.detail.receiver +`</td>
            </tr>
            <tr>
                <th scope="row">TUJUAN</th>
                <td>`+ resi.detail.destination +`</td>
            </tr>
        </tbody>
    </table>
</div> -->

<!-- <div class="col">
    <h1 class="text-center">` + result.message +`</h1>
</div> -->

<?= $this->endSection(); ?>
<?= $this->section('script'); ?>
<script>
    $('document').ready(function() {
        let kode_resi = '<?= $transaksi->kode_resi; ?>';
        console.log(kode_resi);
        $.ajax({
            url: 'https://api.binderbyte.com/v1/track?api_key=1f1bc0dcd2b32ce3d77de82c929ce90e08db001a738bd37d62fdfb8a0dd7f4d5',
            type: 'get',
            dataType: 'json',
            data: {
                'courier': 'jne',
                'awb': kode_resi
            },

            success: function(result) {
                if (result.status == 200) {
                    let resi = result.data;
                    console.log(resi);
                    $('#resi_status').html(`
                        <h3>STATUS PENGIRIMAN</h3>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th scope="row">STATUS</th>
                                    <td>` + resi.summary.status + `</td>
                                </tr>
                                <tr>
                                    <th scope="row">LAYANAN</th>
                                    <td>` + resi.summary.service + `</td>
                                </tr>
                                <tr>
                                    <th scope="row">PENGIRIM</th>
                                    <td>` + resi.detail.shipper + `</td>
                                </tr>
                                <tr>
                                    <th scope="row">ASAL</th>
                                    <td>` + resi.detail.origin + `</td>
                                </tr>
                                <tr>
                                    <th scope="row">PENERIMA</th>
                                    <td>` + resi.detail.receiver + `</td>
                                </tr>
                                <tr>
                                    <th scope="row">TUJUAN</th>
                                    <td>` + resi.detail.destination + `</td>
                                </tr>
                            </tbody>
                        </table>
                    `);
                    var lacakPosisi = '';
                    for (let i = 0; i < resi.history.length; i++) {
                        lacakPosisi +=

                            `
                            <table class="table table-bordered">
                                <tbody class="resi-posisi">
                                    <tr>
                                        <th scope="row">DATE</th>
                                        <td>` + resi.history[i].date + `</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">DESC</th>
                                        <td>` + resi.history[i].desc + `</td>
                                    </tr>
                                </tbody>
                            </table>`

                    }

                    $('#resi_posisi').html(`
                    ${lacakPosisi}
                    
                    `);
                } else {
                    $('#resi_result').html(`
                        <div class="col">
                            <h1 class="text-center">Maaf kode resi yang diinput salah</h1>
                        </div>
                    `)
                }
            }
        });
    });
</script>
<?= $this->endSection(); ?>