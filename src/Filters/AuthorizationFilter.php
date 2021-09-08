<?php

namespace SweetScar\AuthIgniter\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Router\Exceptions\RedirectException;

class AuthorizationFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $authentication = service('authentication');
        $autorization = service('authorization');

        if (!$authentication->check()) {
            session()->set('redirect_url', current_url());
            return redirect('authigniter:login')->with('authigniter_error', lang('AuthIgniter.pleaseLoginFirst'));
        }

        if (is_null($arguments)) return;

        $roles = $arguments;

        $userRole = $autorization->getUserRole($authentication->user());

        if (is_null($userRole)) {
            session()->setFlashdata('forbidden', true);
            session()->setFlashdata('forbidden_url', current_url());
            throw new RedirectException(route_to('authigniter:forbidden'));
        }

        if (!in_array($userRole->name, $roles)) {
            session()->setFlashdata('forbidden', true);
            session()->setFlashdata('forbidden_url', current_url());
            throw new RedirectException(route_to('authigniter:forbidden'));
        }

        return;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        # Not Implemented
    }
}
