<!DOCTYPE html>
<html lang="en">

<head>
    
    <title>Monday to Friday</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800;900&display=swap"
    rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="<?= base_url('template/malefashion-master/css/bootstrap.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('template/malefashion-master/css/font-awesome.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('template/malefashion-master/css/elegant-icons.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('template/malefashion-master/css/magnific-popup.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('template/malefashion-master/css/nice-select.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('template/malefashion-master/css/owl.carousel.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('template/malefashion-master/css/slicknav.min.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('template/malefashion-master/css/style.css')?>" type="text/css">
    <link rel="stylesheet" href="<?= base_url('template/malefashion-master/css/style-new.css')?>" type="text/css">    
</head>

<body>

    <?= $this->include('navbar_new')?>

    <main role="main" class="container">

    <?= $this->renderSection('content')?>

    </main>

    <?= $this->include('footer')?>

    <!-- Js Plugins -->
    <script src="<?= base_url('jquery-3.6.4.min.js')?>"></script>
    <script src="<?= base_url('template/malefashion-master/js/bootstrap.min.js')?>"></script>
    <!-- <script src="<?= base_url('template/malefashion-master/js/jquery.nice-select.min.js')?>"></script> -->
    <script src="<?= base_url('template/malefashion-master/js/jquery.nicescroll.min.js')?>"></script>
    <script src="<?= base_url('template/malefashion-master/js/jquery.magnific-popup.min.js')?>"></script>
    <script src="<?= base_url('template/malefashion-master/js/jquery.countdown.min.js')?>"></script>
    <script src="<?= base_url('template/malefashion-master/js/jquery.slicknav.js')?>"></script>
    <script src="<?= base_url('template/malefashion-master/js/mixitup.min.js')?>"></script>
    <script src="<?= base_url('template/malefashion-master/js/owl.carousel.min.js')?>"></script>
    <script src="<?= base_url('template/malefashion-master/js/main.js')?>"></script>
    <script>
        function previewImg() {
            const gambar = document.querySelector('#gambar');
            const gambarLabel = document.querySelector('.custom-file-label');
            const imgPreview = document.querySelector('.img-preview');

            gambarLabel.textContent = gambar.files[0].name;

            const fileBuktiBayar = new FileReader();
            fileGambar.readAsDataURL(gambar.files[0]);

            fileGambar.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }

        function previewImgBayar() {
            const gambarBuktiBayar = document.querySelector('#bukti_bayar');
            const gambarLabelBayar = document.querySelector('.custom-file-label');
            const imgPreview = document.querySelector('.img-preview');

            gambarLabelBayar.textContent = gambarBuktiBayar.files[0].name;

            const fileBuktiBayar = new FileReader();

            fileBuktiBayar.readAsDataURL(gambarBuktiBayar.files[0]);

            fileBuktiBayar.onload = function(e) {
                imgPreview.src = e.target.result;
            }
        }
    </script>
    <?= $this->renderSection('script')?>
</body>

</html>