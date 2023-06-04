<?php
    $session = session();
?>
    <!-- Header Section Begin -->
    <header class="header">
        <div class="container">
            <div class="row">
                <div class="col-lg-2 col-md-2">
                    <div class="header__logo">
                        <a href="<?= site_url('home')?>"><img src="<?= base_url('mtf/logo monday.png')?>" alt=""></a> 
                    </div>
                </div>
                <div class="col-lg-5 col-md-5">
                    <nav class="header__menu mobile-menu">
                        <ul>
                            <li><a href="<?= site_url('home')?>">Home</a></li>
                            <li><a href="<?= site_url('shop')?>">Shop</a></li>
                            <li><a href="#">Halaman</a>
                                <ul class="dropdown">
                                    <li><a href="<?= site_url('about')?>">Tentang Kami</a></li>
                                    <li><a href="<?= site_url('shop/keranjang')?>">Keranjang</a></li>
                                    <li><a href="#">Transaksi Saya</a></li>
                                </ul>
                            </li>
                            <?php if($session->get('isLoggedin')):?>
                            <li><a href="<?= site_url('logout')?>">Sign Out</a></li>
                            <?php else : ?>
                            <li><a href="<?= site_url('login')?>">Sign In</a></li>
                            <?php endif ?>
                        </ul>
                    </nav>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="header__nav__option">
                        <?php if($session->get('isLoggedin')):?>
                        <h5>Selamat Datang</h5><strong><?= $session->get('username')?></strong>
                    </div>
                </div>
                <div class="col-lg-1 col-md-1">
                    <?php 
                        $keranjang = $cart->contents();
                        $jumlah = 0;
                        foreach ($keranjang as $key => $value){
                            $jumlah = $jumlah+$value['qty'];
                        }
                    ?>
                    <div class="header__nav__option">
                        <a href="<?= site_url('shop/keranjang')?>"><img src="<?= base_url('template/malefashion-master/img/icon/cart.png')?>" width="25" height="30" alt=""><span class="badge badge-danger navbar-badge"><?= $jumlah ?></span></a>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- Header Section End -->