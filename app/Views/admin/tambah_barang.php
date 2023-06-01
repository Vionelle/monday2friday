<?php
    $nama = [
        'name' => 'nama',
        'id' => 'nama',
        'value' => null,
        'class' => 'form-control'
    ];
    $harga = [
        'name' => 'harga',
        'id' => 'harga',
        'value' => null,
        'class' => 'form-control',
        'type' => 'number',
        'min' => 0,
    ];
    $stok = [
        'name' => 'stok',
        'id' => 'stok',
        'value' => null,
        'class' => 'form-control',
        'type' => 'number',
        'min' => 0,
    ];
    $size = [
        'name' => 'size',
        'id' => 'size',
        'value' => null,
        'class' => 'form-control',
    ];
    $gambar = [
        'name' => 'gambar',
        'id' => 'gambar',
        'value' => null,
        'class' => 'form-control'
    ];
    $submit = [
        'name' => 'submit',
        'id' => 'submit',
        'value' => 'Submit',
        'class' => 'btn btn-primary',
        'type' => 'submit'
    ];
    $options = [
        'XXS'  => 'XXS',
        'XS'  => 'XS',
        'S'  => 'S',
        'M'    => 'M',
        'L'  => 'L',
        'XL' => 'XL',
        'XXL'  => 'XXL',
    ];
    $session = session();
    $errors = $session->getFlashdata('errors');
?>
<div class="card-header">
    <!-- <i class="fas fa-table me-1"></i> -->
    <h6 class="mt-3">Tambah Barang</h6>
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
    <?= form_open_multipart('admin/tambahbarang')?>
        <div class="form-group mb-3">
            <?= form_label("Nama","nama")?>
            <?= form_input($nama)?> 
        </div>
        <div class="form-group mb-3">
            <?= form_label("Harga","Harga")?>
            <?= form_input($harga)?> 
        </div>
        <div class="form-group mb-3">
            <?= form_label("Stok","stok")?>
            <?= form_input($stok)?> 
        </div>
        <div class="form-group mb-3">
            <?= form_label("Size","size")?>
            <?= form_dropdown('size',$options)?> 
        </div>
        <div class="from-group">
            <?= form_label("Gambar","gambar")?>
            <?= form_upload($gambar)?>
        </div>
        <div style="float:right" class="text-right mt-3">
            <?= form_submit($submit)?>
        </div>
    <? form_close()?>
</div>
                        
