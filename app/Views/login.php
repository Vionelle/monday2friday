<?= $this->extend('layout_new')?>
<?= $this->section('content')?>
<div id="layoutAuthentication_content">
    <main>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <div class="card shadow-lg border-0 rounded-lg mt-5 mb-5">
                        <div class="card-header"><h3 class="text-center font-weight-light my-4">Login</h3></div>
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
                            <form method="POST" action="<?php echo site_url('login')?>">
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputUsername" type="text" placeholder="Username" name="username" value="<?php if($session->getFlashdata('username')) echo $session->getFlashdata('username') ?>" />
                                    <label for="inputUsername">Username</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input class="form-control" id="inputPassword" type="password" name="password" placeholder="Password" />
                                    <label for="inputPassword">Password</label>
                                </div>
                                <!-- <div class="form-check mb-3">
                                    <input class="form-check-input" id="inputRememberPassword" name="remember_me" type="checkbox" value="1" />
                                    <label class="form-check-label" for="inputRememberPassword">Remember Password</label>
                                </div> -->
                                <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                    <a class="small" href="<?= site_url('lupa_password')?>">Lupa Password?</a>
                                    <input type="submit" class="btn btn-dark" name="submit" value="LOGIN"/>
                                </div>
                            </form>
                        </div>
                        <div class="card-footer text-center py-3">
                            <div class="small"><a href="<?= base_url('register')?>">Belum punya akun? Sign up!</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<?= $this->endSection()?>