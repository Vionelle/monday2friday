<?= $this->extend('layout_new') ?>
<?= $this->section('content') ?>
<?php 
    $session = session();
    $success = $session->getFlashdata('success');
    $kosong  = $session->getFlashdata('kosong');
?>
<!-- Shop Section Begin -->
    <section class="shop">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="shop__sidebar">
                        <div class="shop__sidebar__accordion">
                            <div class="accordion" id="accordionExample">
                                <!-- <div class="card">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseThree">Filter Price</a>
                                    </div>
                                    <div id="collapseThree" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__price">
                                                <ul>
                                                    <li><a href="#">$0.00 - $50.00</a></li>
                                                    <li><a href="#">$50.00 - $100.00</a></li>
                                                    <li><a href="#">$100.00 - $150.00</a></li>
                                                    <li><a href="#">$150.00 - $200.00</a></li>
                                                    <li><a href="#">$200.00 - $250.00</a></li>
                                                    <li><a href="#">250.00+</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <div class="card mb-1">
                                    <div class="card-heading">
                                        <a data-toggle="collapse" data-target="#collapseFour">Size</a>
                                    </div>
                                    <div id="collapseFour" class="collapse show" data-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="shop__sidebar__size">
                                            <form method="GET" action="<?php echo site_url('shop')?>">
                                                <label for="xxs">xxs
                                                    <input type="submit" id="xxs" name="size" value="xxs">
                                                </label>
                                                <label for="xs">xs
                                                    <input type="submit" id="xs" name="size" value="xs">
                                                </label>
                                                <label for="s">s
                                                    <input type="submit" id="s" name="size" value="s">
                                                </label>
                                                <label for="m">m
                                                    <input type="submit" id="m" name="size" value="m">
                                                </label>
                                                <label for="l">l
                                                    <input type="submit" id="l" name="size" value="l">
                                                </label>
                                                <label for="xl">xl
                                                    <input type="submit" id="xl" name="size" value="xl"> 
                                                </label>
                                                <label for="xxl">xxl
                                                    <input type="submit" id="xxl" name="size" value="xxl">
                                                </label>
                                            </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9">
                    <?php
                        if ($success != null){
                            echo '<div class="alert alert-success alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                            echo $success;
                            echo '</div>';
                        }
                        if ($kosong != null){
                            echo '<div class="alert alert-warning alert-dismissible">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>';
                            echo $kosong;
                            echo '</div>';
                        }
                    ?>
                    <div class="shop__product__option">
                        <!-- <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__left">
                                    <p>Showing 1–12 of 126 results</p>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="shop__product__option__right">
                                    <p>Sort by Price:</p>
                                    <select>
                                        <option value="">Low To High</option>
                                        <option value="">$0 - $55</option>
                                        <option value="">$55 - $100</option>
                                    </select>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="row">
                        <?php foreach($model as $m): ?>
                            <div class="col-4">
                                <form method="POST" action="<?php echo site_url('shop/tambah')?>">
                                <?php 
                                    echo form_hidden('id', $m->id_barang);
                                    echo form_hidden('price', $m->harga);
                                    echo form_hidden('name', $m->nama);
                                    echo form_hidden('size', $m->size);
                                    echo form_hidden('gambar', $m->gambar);
                                ?>
                                <?php if($m->stok > 0): ?>
                                    <div class="product__item sale">
                                        <div class="product__item__pic set-bg" data-setbg="<?= base_url('uploads/'.$m->gambar) ?>">
                                        
                                            <a href="<?= site_url('shop/beli/'.$m->id_barang)?>"><span class="label">Beli sekarang</span></a>
                                        
                                        </div>
                                        <div class="product__item__text">
                                            <div class="product__content">
                                                <h6><?= $m->nama?></h6>
                                                
                                                <button type="submit" class="add-cart" >+ Tambah Ke Keranjang</button>
                                                
                                                <h5><?= "Rp. ".number_format($m->harga,2,',','.') ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="product__item sale">
                                        <div class="product__item__pic set-bg" data-setbg="<?= base_url('mtf/sold_out2.png') ?>">
                                                                               
                                        </div>
                                        <div class="product__item__text">
                                            <div class="product__content">
                                                <h6><?= $m->nama?></h6>
                                                
                                                <button type="button" class="add-cart" >Sold Out</button>
                                                
                                                <h5><?= "Rp. ".number_format($m->harga,2,',','.') ?></h5>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ?>
                                </form>
                            </div>
                        <?php endforeach ?>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 mb-3">
                            <div style="float:right">
                                <?= $data['pager']->links('default','custom_pagination') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->
<?= $this->endSection() ?>