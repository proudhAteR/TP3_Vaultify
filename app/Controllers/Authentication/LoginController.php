<?php

namespace Controllers\Authentication;

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
        return $this->display(page: 'login', args: ['title' => 'Login']);
    }

    #[Post('/')]
    public function authenticate(): Response
    {
        $form = $this->buildForm();
        $acc = AccountService::authenticate($form);

        return $this->connect($acc, $form);
    }
}