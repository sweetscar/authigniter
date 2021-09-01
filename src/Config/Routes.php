<?php

$routes->group('', ['namespace' => 'SweetScar\AuthIgniter\Controllers'], function ($routes) {

    $routes->get('login', 'AuthIgniter::login', ['as' => 'authigniter:login']);
    $routes->post('attempt-login', 'AuthIgniter::attemptLogin', ['as' => 'authigniter:attemptLogin']);

    $routes->get('register', 'AuthIgniter::register', ['as' => 'authigniter:register']);
    $routes->post('attempt-register', 'AuthIgniter::attemptRegister', ['as' => 'authigniter:attemptRegister']);

    if (config('AuthIgniter')->enableForgotPassword) {
        $routes->get('forgot-password', 'AuthIgniter::forgotPassword', ['as' => 'authigniter:forgotPassword']);
        $routes->post('attempt-forgot-password', 'AuthIgniter::attemptForgotPassword', ['as' => 'authigniter:attemptForgotPassword']);
        $routes->get('reset-password', 'AuthIgniter::resetPassword', ['as' => 'authigniter:resetPassword']);
        $routes->post('attempt-reset-password', 'AuthIgniter::attemptResetPassword', ['as' => 'authigniter:attemptResetPassword']);
    }

    if (config('AuthIgniter')->enableEmailVerification) {
        $routes->get('verify-email', 'AuthIgniter::verifyEmail', ['as' => 'authigniter:verifyEmail']);
    }
});
