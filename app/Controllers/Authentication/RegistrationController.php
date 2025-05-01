<?php

namespace Controllers\Authentication;

use Models\Services\AccountService;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Post;
use Zephyrus\Network\Router\Root;

#[Root("/register")]
class RegistrationController extends AuthenticationController
{
    #[Get('/')]
    public function index(): Response
    {
        return $this->display('Register', ['title' => 'Register']);
    }

    #[Post('/')]
    public function register(): Response
    {
        $form = $this->buildForm();
        $acc = AccountService::register($form);

        return $this->connect($acc, $form);
    }
}