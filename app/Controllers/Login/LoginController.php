<?php

namespace Controllers\Login;

use Controllers\Controller;
use Models\Services\AccountService;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Post;
use Zephyrus\Network\Router\Root;

#[Root('/login')]
class LoginController extends Controller
{
    #[Get('/')]
    public function index(): Response
    {
        return !$this->isAuth() ?
            $this->render('login', ['title' => 'Login']) :
            $this->redirectBack($this->request);
    }

    #[Post('/')]
    public function authenticate(): Response
    {
        $acc = AccountService::authenticate($this->buildForm());
        $_SESSION["user"] = $acc->id;

        return $this->redirect("/");
    }
}