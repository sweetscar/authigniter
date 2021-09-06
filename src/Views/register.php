<?= $this->extend($config->viewLayout) ?>

<?= $this->section('main') ?>
<div class="py-5">
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h4 class="text-center"><?= lang('AuthIgniter.registerPageTitle') ?></h4>
                </div>
                <div class="card-body">
                    <form action="<?= route_to('authigniter:attemptRegister') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <input type="email" name="email" id="email" class="form-control <?= (session('errors.email')) ? 'is-invalid' : '' ?>" placeholder="<?= lang('AuthIgniter.email') ?>" value="<?= old('email') ?>">
                            <span class="invalid-feedback"><?= session('errors.email') ?></span>
                        </div>

                        <?php if ($config->enableUsername) : ?>
                            <div class="mb-3">
                                <input type="text" name="username" id="username" class="form-control <?= (session('errors.username')) ? 'is-invalid' : '' ?>" placeholder="<?= lang('AuthIgniter.username') ?>" value="<?= old('username') ?>">
                                <span class="invalid-feedback"><?= session('errors.username') ?></span>
                            </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <input type="password" name="password" id="password" class="form-control <?= (session('errors.password')) ? 'is-invalid' : '' ?>" placeholder="<?= lang('AuthIgniter.password') ?>">
                            <span class="invalid-feedback"><?= session('errors.password') ?></span>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="repeat-password" id="repeat-password" class="form-control <?= (session('errors.repeat-password')) ? 'is-invalid' : '' ?>" placeholder="<?= lang('AuthIgniter.repeatPassword') ?>">
                            <span class="invalid-feedback"><?= session('errors.repeat-password') ?></span>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary w-100"><?= lang('AuthIgniter.register') ?></button>
                        </div>
                    </form>

                    <div class="text-center py-2">
                        <a href="<?= route_to('authigniter:login') ?>" class="link-primary text-decoration-none"><?= lang('AuthIgniter.haveAccount') ?></a>
                        <?php if ($config->enableForgotPassword) : ?>
                            <br>
                            <a href="<?= route_to('authigniter:forgotPassword') ?>" class="link-primary text-decoration-none"><?= lang('AuthIgniter.forgotPassword') ?></a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>