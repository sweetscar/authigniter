<?php

namespace SweetScar\AuthIgniter\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\Router\Exceptions\RedirectException;

class AuthorizationFilter implements FilterInterface
{
    /**
     * {@inheritdoc}
     */
    public function before(RequestInterface $request, $arguments = null)
    {
        $authentication = service('authentication');
        $authorization = service('authorization');

        if (!$authentication->check()) {
            session()->set('redirect_url', current_url());
            return redirect('authigniter:login')->with('authigniter_error', lang('AuthIgniter.pleaseLoginFirst'));
        }

        $user = $authentication->user();
        $groups = $arguments;
        $userGroups = $authorization->getUserGroups($user);

        if (is_null($arguments)) return;

        if (empty($userGroups)) {
            throw new RedirectException('', 403);
        }

        if (in_array('*', $groups)) {
            return;
        } else {
            if (array_intersect($groups, $userGroups) == []) {
                throw new RedirectException('', 403);
            } else {
                return;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        # Not Implemented
    }
}
