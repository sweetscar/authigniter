<?php if (session()->has('authigniter_info')) : ?>
    <div class="alert alert-success">
        <?= session('authigniter_info') ?>
    </div>
<?php endif ?>
<?php if (session()->has('authigniter_error')) : ?>
    <div class="alert alert-danger">
        <?= session('authigniter_error') ?>
    </div>
<?php endif ?>