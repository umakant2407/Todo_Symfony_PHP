<?php

namespace AppBundle;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;

class LogoutListener implements  LogoutSuccessHandlerInterface
{
    
    public function onLogoutSuccess(Request $request): Response
    {
        return new Response('', 401);
    }
}
