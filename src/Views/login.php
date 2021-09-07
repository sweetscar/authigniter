<?= $this->extend($config->viewLayout) ?>

<?= $this->section('main') ?>
<div class="py-5">
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h4 class="text-center"><?= lang('AuthIgniter.loginPageTitle') ?></h4>
                </div>
                <div class="card-body">
                    <?= view('SweetScar\AuthIgniter\Views\_message_block') ?>
                    <form action="<?= route_to('authigniter:attemptLogin') ?>" method="POST">

                        <?= csrf_field() ?>

                        <?php if ($config->enableUsername) : ?>
                            <div class="mb-3">
                                <input type="text" name="login" id="login" class="form-control <?= (session('errors.login')) ? 'is-invalid' : '' ?>" placeholder="<?= lang('AuthIgniter.usernameOrEmail') ?>" value="<?= old('login') ?>" autofocus>
                                <span class="invalid-feedback"><?= session('errors.login') ?></span>
                            </div>
                        <?php else : ?>
                            <div class="mb-3">
                                <input type="email" name="login" id="login" class="form-control <?= (session('errors.login')) ? 'is-invalid' : '' ?>" placeholder="<?= lang('AuthIgniter.email') ?>" value="<?= old('login') ?>" autofocus>
                                <span class="invalid-feedback"><?= session('errors.login') ?></span>
                            </div>
                        <?php endif; ?>
                        <div class="mb-3">
                            <input type="password" name="password" id="password" class="form-control <?= (session('errors.password')) ? 'is-invalid' : '' ?>" placeholder="<?= lang('AuthIgniter.password') ?>">
                            <span class="invalid-feedback"><?= session('errors.password') ?></span>
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary w-100"><?= lang('AuthIgniter.login') ?></button>
                        </div>
                    </form>

                    <div class="text-center py-2">
                        <a href="<?= route_to('authigniter:register') ?>" class="link-primary text-decoration-none"><?= lang('AuthIgniter.notHaveAccount') ?></a>
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