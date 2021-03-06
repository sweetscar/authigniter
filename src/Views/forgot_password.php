<?= $this->extend($config->viewLayout) ?>

<?= $this->section('title') ?>
<?= lang('AuthIgniter.requestResetPasswordLink') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="py-5">
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h4 class="text-center"><?= lang('AuthIgniter.requestResetPasswordLink') ?></h4>
                </div>
                <div class="card-body">
                    <?= view('SweetScar\AuthIgniter\Views\_message_block') ?>
                    <form action="<?= route_to('authigniter:attemptForgotPassword') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <input type="email" name="email" id="email" class="form-control <?= (session('errors.email')) ? 'is-invalid' : '' ?>" placeholder="<?= lang('AuthIgniter.email') ?>" value="<?= old('email') ?>" autofocus>
                            <span class="invalid-feedback"><?= session('errors.email') ?></span>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary w-100"><?= lang('AuthIgniter.getResetPasswordLink') ?></button>
                        </div>
                    </form>

                    <div class="text-center py-2">
                        <a href="<?= route_to('authigniter:register') ?>" class="link-primary text-decoration-none"><?= lang('AuthIgniter.notHaveAccount') ?></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>