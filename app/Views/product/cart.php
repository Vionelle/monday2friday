<?= $this->extend('layout_new') ?>
<?= $this->section('content') ?>
<?php 
    $session = session();
    $kosong = "Keranjang belanja masih kosong"
?>
    <div class="container">
        <div class="row">
            <div class="col-12">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th width="75px">Qty</th>
                        <th width="250px">Nama</th>
                        <th width="200px">Gambar</th>
                        <th width="50px">Size</th>
                        <th>Harga</th>
                        <th>Total</th>
                        <th>Hapus</th>
                    </tr>
                    </thead>
                    <tbody>
                        <?php if($cart->totalItems()==0) { ?>
                            <div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                            <?php echo $kosong ?>
                            </div>
                        <?php }else{ 
                                foreach($cart->contents() as $key => $value) { ?> 
                                    <tr>
                                        <td><input type="number" min="1" name="qty" class="form-control" value="<?= $value["qty"] ?>"></td>
                                        <td><?= $value['name'] ?></td>
                                        <td><img class="img-fluid" style="max-height:200px"
                                        src="<?= base_url('uploads/'.$value['options']['gambar']) ?>"></td>
                                        <td><?= $value['options']['size'] ?></td>
                                        <td><?= "Rp. ".number_format($value['price'],2,',','.') ?></td>
                                        <td><?= "Rp. ".number_format($value['subtotal'],2,',','.') ?></td>
                                        <td>
                                            <a href="" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                           <?php } ?>  
                        <?php } ?>                                                       
                    </tbody>
                </table>
            </div>
            <!-- <div class="col-3 table-responsive">
                <h1></h1>
            </div> -->
        </div>
        <div class="row">
            <div class="col-6">

            </div>
            <div class="col-6">
                <div class="table-responsive">
                    <table class="table">
                        <tr>
                            <th style="width:50%">Subtotal:</th>
                            <td><?= "Rp. ".number_format($cart->total(),2,',','.') ?></td>
                        </tr>
                        <!-- <tr>
                            <th>Ongkir:</th>
                            <td>Rp. 1.000.000,00</td>
                        </tr>
                        <tr>
                            <th>Total:</th>
                            <td>Rp. 1.000.000,00</td>
                        </tr> -->
                    </table>
                </div>
            </div>
        </div>
        <div class="row">
            <button type="submit" class="btn btn-primary mb-3 mr-3">Update</button>
            <button type="submit" class="btn btn-success float-end mb-3" style="float:right">Check Out</button>
        </div>
    </div>
                      
<?= $this->endSection() ?>