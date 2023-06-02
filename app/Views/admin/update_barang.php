<?php
    $nama = [
        'name' => 'nama',
        'id' => 'nama',
        'value' => $barang->nama,
        'class' => 'form-control'
    ];
    $harga = [
        'name' => 'harga',
        'id' => 'harga',
        'value' => $barang->harga,
        'class' => 'form-control',
        'type' => 'number',
        'min' => 0,
    ];
    $stok = [
        'name' => 'stok',
        'id' => 'stok',
        'value' => $barang->stok,
        'class' => 'form-control',
        'type' => 'number',
        'min' => 0,
    ];
    $size = [
        'name' => 'size',
        'id' => 'size',
        'value' => $barang->size,
        'class' => 'form-control',
        'readonly' => true
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
?>
<div class="card-header">
    <h6 class="mt-3">Update Barang</h6>
</div>
<div class="card-body">
    <?= form_open_multipart('admin/updatebarang/'.$barang->id)?>
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
            <?= form_input($size)?> 
        </div>
        <div class="form-group mb-3">
            <?= form_label("Size","size")?>
            <?= form_dropdown('size',$options)?> 
        </div>
        
        <img class="img-fluid" style="max-height:200px" alt="image" src="<?= base_url('uploads/'.$barang->gambar)?>"/>
        <div class="from-group">
            <?= form_label("Gambar","gambar")?>
            <?= form_upload($gambar)?>
        </div>
        <div class="text-right mt-3">
            <?= form_submit($submit)?>
        </div>
    <? form_close()?>
</div>