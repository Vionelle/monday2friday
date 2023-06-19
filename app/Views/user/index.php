<?= $this->extend('layout_new')?>
<?= $this->section('content')?>
<div class="user-container container-fluid">

    <!-- Page Heading -->
    <div class="user-heading">
        <h2 class="h3 text-center ">PROFIL</h2>
    </div>

    <div class="user-content row">
        <div class="card mb-3" style="width: 650px;">
            <div class="row no-gutters">
                <div class="col-md-8">
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">
                                <h4><?= $user->username ?></h4>
                            </li>
                            <li class="list-group-item"><?= $user->email ?></li>
                            <li class="list-group-item"><?= $user->kontak ?></li>
                            <li class="list-group-item"><a class="btn btn-primary" href="<?= site_url('profil/edit')?>">Edit</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>