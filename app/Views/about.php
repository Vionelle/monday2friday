<?= $this->extend('layout_new')?>
<?= $this->section('content')?>
    <!-- About Section Begin -->
    <section class="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about__pic">
                        <img src="<?= base_url('mtf/bannerab1.png')?>" alt="">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 col-md-4 col-sm-6">
                    <div class="about__item">
                        <h4>Tentang Kami</h4>
                        <p>Monday to Friday adalah UMKM yang mendesain pakaian wanita modis, kami selalu menyediakan pakaian-pakaian dengan desain terbaik. Mulai dari, dress, blouse, skirt, kemeja dan masih banyak lagi</p>
                    </div>
                </div>
                <div class="col-lg-1 col-md-4 col-sm-6"></div>
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="about__item">
                        <h4>Hubungi Kami</h4>
                        <a href="https://wa.me/+6281770785745" target="_blank"><img src="<?= base_url('mtf/WhatsApp_black.png')?>" alt="" width="48" height="48"></a>
                        <a href="https://www.instagram.com/monday_tofriday/" target="_blank"><img src="<?= base_url('mtf/Instagram_black.png')?>" alt="" width="48" height="48"></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->
<?= $this->endSection()?>