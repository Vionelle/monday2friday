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
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="about__item">
                        <h4>Who We Are ?</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="about__item">
                        <h4>Why Choose Us</h4>
                        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- About Section End -->
<?= $this->endSection()?>