<?php

namespace SweetScar\AuthIgniter\Filters;

use Config\App;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthenticationFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $current = (string)current_url(true)
            ->setHost('')
            ->setScheme('')
            ->stripQuery('token', 'email');

        $config = config(App::class);
        if ($config->forceGlobalSecureRequests) {
            # Remove "https:/"
            $current = substr($current, 7);
        }

        if (in_array(
            (string)$current,
            [
                route_to('authigniter:login'),
                route_to('authigniter:attemptLogin'),
                route_to('authigniter:register'),
                route_to('authigniter:attemptRegister'),
                route_to('authigniter:forgotPassword'),
                route_to('authigniter:attemptForgotPassword'),
                route_to('authigniter:resetPassword'),
                route_to('authigniter:attemptResetPassword'),
                route_to('authigniter:resetPasswordResult'),
                route_to('authigniter:verifyEmail')
            ]
        )) {
            return;
        }

        $authentication = service('authentication');

        if (!$authentication->check()) {
            session()->set('redirect_url', current_url());
            return redirect('authigniter:login')->with('authigniter_error', lang('AuthIgniter.pleaseLoginFirst'));
        }

        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        # Not Implemented
    }
}
