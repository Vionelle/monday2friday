<?= $this->extend('layout_new')?>
<?= $this->section('content')?>
<?php 
    $session = session(); 
?>
    <!-- Banner Section Begin -->
    <section class="banner mb-3">
        <div class="container hero__items set-bg" data-setbg="<?= base_url('mtf/banner1.png')?>">
            <div class="row">
                <div class="col-lg-5">
                    <div class="banner__item banner__item--middle">
                        <div class="banner__item__text">
                            <h2>Clothing</h2>
                            <a href="<?= site_url('shop')?>">Shop now</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->

    <!-- Instagram Section Begin -->
    
    <!-- Instagram Section End -->
<?= $this->endSection()?>