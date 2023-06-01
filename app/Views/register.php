<?= $this->extend('layout_new')?>
<?= $this->section('content')?>
<div id="layoutAuthentication_content">
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5 mb-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Register</h3></div>
                        <div class="card-body">
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
                            <form method="POST" action="<?php echo site_url('register')?>">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputUsername" type="text" placeholder="" name="username"/>
                                    <label for="inputUsername">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputEmail" type="text" name="email" placeholder="" />
                                    <label for="inputEmail">Email</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputPassword" type="password" name="password" placeholder="" />
                                    <label for="inputPassword">Password</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="konfirmasiPassword" type="password" name="repeatPassword" placeholder="" />
                                    <label for="konfirmasiPassword">Konfirmasi Password</label>
                                </div>
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <input type="submit" class="btn btn-dark" name="submit" value="REGISTER"/>
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