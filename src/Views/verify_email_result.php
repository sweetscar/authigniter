<?= $this->extend($config->viewLayout) ?>

<?= $this->section('main') ?>
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="text-center">
        <?php if ($type == 'success') : ?>
            <h4 class="text-success"><?= lang('AuthIgniter.emailVerificationSuccess') ?></h4>
        <?php else : ?>
            <h4 class="text-danger"><?= lang('AuthIgniter.emailVerificationError') ?></h4>
        <?php endif; ?>
        <br>
        <p><?= $message ?></p>
    </div>
</div>
<?= $this->endSection() ?>