<?= $this->extend('layout_new') ?>
<?= $this->section('content') ?>
<?php
    $id_pembeli = [
        'name' => 'id_pembeli',
        'id' => 'id_pembeli',
        'value' => session()->get('id'),
        'type' =>  'hidden'
    ];
    $subtotal = [
        'name' => 'subtotal',
        'id' => 'subtotal',
        'value' => $cart->total(),
        'class' => 'form-control',
        'readonly' => true,
    ];
    $ongkir = [
        'name' => 'ongkir',
        'id' => 'ongkir',
        'value' => null,
        'class' => 'form-control',
        'readonly' => true
    ];
    $total_harga = [
        'name' => 'total_harga',
        'id' => 'total_harga',
        'value' => null,
        'class' => 'form-control',
        'readonly' => true
    ];
    $alamat = [
        'name' => 'alamat',
        'id' => 'alamat',
        'value' => null,
        'class' => 'form-control',
    ];
    $submit = [
        'name' => 'submit',
        'id' => 'submit',
        'value' => 'Beli',
        'class' => 'btn btn-dark mb-3',
        'type' => 'submit'
    ];

    $session = session();
    $errors = $session->getFlashdata('errors');
?>
    <div class="container">
    <?php if($errors != null) : ?>
        <div class="alert alert-warning" role="alert">
            <?= session()->getFlashdata('errors'); ?>
        </div>
    <?php endif ?>
        <div class="row">
            <div class="col-6">  
                <div class="card mb-2">
                    <?php foreach ($model as $key => $value): ?>
                    <div class="card-body">
                        <img class="img-fluid" style="max-height:100px"
                        src="<?= base_url('uploads/'.$value['options']['gambar']) ?>"/>
                        <h4 class="text-success"><?= $value['name']." (".$value['qty'].")" ?></h3>
                        <h5><?= "Rp. ".number_format($value['price'],2,',','.') ?></h4>
                    </div>
                    <?php endforeach ?>
                </div>                
            </div>
            <div class="col-6">
                <h4 class="mb-3">Pengiriman</h4>
                <div class="form-group">
                <label for="provinsi">Pilih Provinsi</label>
                    <select class="form-control" id="provinsi">
                        <option>Select Provinsi</option>
                        <?php foreach($provinsi as $p): ?>
                            <option value="<?= $p->province_id ?>">
                            <?= $p->province ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
                <div class="form-group">
                <label for="kota">Pilih Kota</label>
                    <select class="form-control" id="kota">
                        <option>Select Kota</option>
                    </select>
                </div>
                <div class="form-group">
                <label for="service">Pilih Service (JNE)</label>
                    <select class="form-control" id="service">
                        <option>Select Service</option>
                    </select>
                </div>

                <strong>Estimasi : <span id="estimasi"></span></strong>
                <hr>

                <?= form_open('shop/checkout') ?>
                    <?= form_input($id_pembeli) ?>
                    <div class="form-group">
                        <?= form_label('Subtotal', 'subtotal') ?>
                        <?= form_input($subtotal) ?>
                    </div>
                    <div class="form-group">
                        <?= form_label('Ongkir', 'ongkir') ?>
                        <?= form_input($ongkir) ?>
                    </div>
                    <div class="form-group">
                        <?= form_label('Total Harga', 'total_harga') ?>
                        <?= form_input($total_harga) ?>
                    </div>
                    <div class="form-group">
                        <?= form_label('Alamat', 'alamat') ?>
                        <?= form_input($alamat) ?>
                    </div>
                    <div class="text-right">
                        <?= form_submit($submit) ?>
                    </div>
                <? form_close() ?>
            </div>
        </div>
    </div>            

<?= $this->endSection() ?>
<?= $this->section('script') ?>
    <script>
        $('document').ready(function(){
            var jumlah_pembelian = 1;
            var harga = <?= $cart->total() ?>;
            var ongkir = 0;
            
            $("#provinsi").on('change',function(){
                $("#kota").empty();
                var id_province = $(this).val();
                console.log(id_province)
                $.ajax({
                    url : "<?= site_url('shop/provinsi') ?>",
                    type : 'GET',
                    data : {
                        'id_province' : id_province
                    },
                    dataType : 'json',
                    success : function(data){
                        console.log(data);
                        var results = data["rajaongkir"]["results"];
                        for(var i=0; i<results.length; i++){
                            $("#kota").append($('<option>',{
                                value : results[i]["city_id"],
                                text : results[i]["city_name"]
                            }));
                        }
                    }
                });
            });

            $("#kota").on('change',function(){
                $("#service").empty();
                var id_city = $(this).val();
                $.ajax({
                    url : "<?= site_url('shop/biaya') ?>",
                    type : 'GET',
                    data : {
                        'origin' : 153,
                        'destination' : id_city,
                        'weight' : 1000,
                        'courier' : 'jne'
                    },
                    dataType : 'json',
                    success : function(data){
                        console.log(data);
                        var results = data["rajaongkir"]["results"][0]["costs"];
                        for(var i=0; i<results.length; i++){
                            var text = results[i]["description"]+"("+results[i]["service"]+")";
                            $("#service").append($('<option>',{
                                value : results[i]["cost"][0]["value"],
                                text : text,
                                etd : results[i]["cost"][0]["etd"]
                            }));
                        }
                    }
                });
            });

            $("#service").on('change',function(){
                var estimasi = $('option:selected',this).attr('etd');
                ongkir = parseInt($(this).val());
                $("#ongkir").val(ongkir);
                $("#estimasi").html(estimasi+" Hari");
                var total_harga = harga+ongkir;
                $("#total_harga").val(total_harga);
            });

            $("#jumlah").on('change',function(){
                jumlah_pembelian = $("#jumlah").val();
                var total_harga  = harga+ongkir;
                $("#total_harga").val(total_harga);
            });
        });
    </script>
<?= $this->endSection() ?>