<?= $this->extend($config->viewLayout) ?>

<?= $this->section('main') ?>
<div class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="text-center">
        <h1 class="text-danger">403</h1>
        <p><b><?= lang('AuthIgniter.forbiddenMessage') ?></b></p>
        <p><b><?= $forbiddenURL ?></b></p>
    </div>
</div>
<?= $this->endSection() ?>