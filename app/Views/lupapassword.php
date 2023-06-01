<?= $this->extend('layout_new')?>
<?= $this->section('content')?>
<div id="layoutAuthentication_content">
    <main>
    <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5 mb-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Password Recovery</h3></div>
                        <div class="card-body">
                            <div class="small mb-3 text-muted">Masukkan email anda dan kami akan mengirim link untuk mereset password anda.</div>
                            <?php
                            $session = session();
                            $errors = $session->getFlashdata('errors');
                            $success = $session->getFlashdata('success');
                            if ($errors != null){?>
                                <div class="alert alert-warning">
                                    <ul>
                                        <?php
                                        foreach($errors as $err){?>
                                            <li><?php echo $err ?></li>
                                        <?php
                                        }?>
                                    </ul>
                                </div><?php
                            }
                            if ($success != null){?>
                                <div class="alert alert-success">
                                    <?php echo $success ?>
                                </div>
                            <?php    
                            }
                            ?>
                            <form action="" method="POST">
                            <div class="form-floating mb-3">
                                    <input class="form-control" id="inputEmail" type="text" name="username" value="<?php if($session->getFlashdata('username')) echo $session->getFlashdata('username') ?>" placeholder="name@example.com" />
                                    <label for="inputEmail">Email address / Username</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a class="small" href="<?php echo site_url('login')?>">Return to login</a>
                                    <input type="submit" class="btn btn-dark" name="submit" value="Kirim Email Recovery"/>
                                </div>
                            </form>
                        </div>                                    
                    </div>
                </div>
             </div>
        </div>
    </main>
</div>
<?= $this->endSection()?>