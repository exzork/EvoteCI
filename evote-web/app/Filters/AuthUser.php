<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthUser implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('is_user')) {
            return redirect()->to(base_url("user"));
        }
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}
