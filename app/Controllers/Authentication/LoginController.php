<?php

namespace Controllers\Authentication;

use Controllers\AppController;
use Models\Services\AccountService;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Post;
use Zephyrus\Network\Router\Root;

#[Root('/login')]
class LoginController extends AuthenticationController
{
    #[Get('/')]
    public function index(): Response
    {
        return $this->display('login', ['title' => 'Login']);
    }

    #[Post('/')]
    public function authenticate(): Response
    {
        $acc = AccountService::authenticate($this->buildForm());
        return $this->connect($acc->id);
    }
}