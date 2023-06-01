<?= $this->extend('layout_new')?>
<?= $this->section('content')?>
<?php 
    $session = session(); 
?>
    <!-- Banner Section Begin -->
    <section class="banner">
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
    <section class="instagram">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="instagram__pic">
                        <div class="hero__items set-bg" data-setbg="<?= base_url('mtf/instagraml.png')?>"></div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="instagram__text">
                        <a href="https://www.instagram.com/monday_tofriday/" target="_blank"><h2>Instagram</h2></a>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <h3>#adaywithmonday</h3>
                    </div>
                </div>              
            </div>
        </div>
    </section>
    <!-- Instagram Section End -->
<?= $this->endSection()?>