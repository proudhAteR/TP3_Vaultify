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
        return $this->display('login', ['title' => 'Login']);
    }

    protected function display(string $page, array $args, string $url = "/login"): Response
    {
        return !isAuth() ?
            $this->render($page, $args) :
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