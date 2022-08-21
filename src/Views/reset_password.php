<?= $this->extend($config->viewLayout) ?>

<?= $this->section('title') ?>
<?= lang('AuthIgniter.resetPasswordPageTitle') ?>
<?= $this->endSection() ?>

<?= $this->section('main') ?>
<div class="py-5">
    <div class="row">
        <div class="col-lg-4 mx-auto">
            <div class="card shadow">
                <div class="card-header py-3">
                    <h4 class="text-center"><?= lang('AuthIgniter.resetPasswordPageTitle') ?></h4>
                </div>
                <div class="card-body">
                    <form action="<?= route_to('authigniter:attemptResetPassword') ?>" method="POST">

                        <?= csrf_field() ?>

                        <input type="hidden" name="token" value="<?= $resetPasswordToken ?>">

                        <div class="mb-3">
                            <input type="password" name="new-password" id="new-password" class="form-control <?= (session('errors.new-password')) ? 'is-invalid' : '' ?>" placeholder="<?= lang('AuthIgniter.newPassword') ?>" autofocus>
                            <span class="invalid-feedback"><?= session('errors.new-password') ?></span>
                        </div>
                        <div class="mb-3">
                            <input type="password" name="repeat-new-password" id="repeat-new-password" class="form-control <?= (session('errors.repeat-new-password')) ? 'is-invalid' : '' ?>" placeholder="<?= lang('AuthIgniter.repeatNewPassword') ?>">
                            <span class="invalid-feedback"><?= session('errors.repeat-new-password') ?></span>
                        </div>

                        <div>
                            <button type="submit" class="btn btn-primary w-100"><?= lang('AuthIgniter.updatePassword') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>