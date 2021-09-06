<?= $this->extend($config->viewLayout) ?>

<?= $this->section('main') ?>
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="text-center">
        <?php if ($type == 'success') : ?>
            <h4 class="text-success"><?= lang('AuthIgniter.resetPasswordSuccess') ?></h4>
        <?php else : ?>
            <h4 class="text-danger"><?= lang('AuthIgniter.resetPasswordError') ?></h4>
        <?php endif; ?>
        <br>
        <p><?= $message ?></p>
        <?php if ($type == 'success') : ?>
            <a href="<?= route_to('authigniter:login') ?>" class="link-primary text-decoration-none"><?= lang('AuthIgniter.login') ?></a>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>