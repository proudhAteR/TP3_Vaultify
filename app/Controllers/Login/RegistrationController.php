<?php

namespace Controllers\Login;

use Controllers\AppController;
use Models\Services\AccountService;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Post;
use Zephyrus\Network\Router\Root;

#[Root("/register")]
class RegistrationController extends AppController
{
    #[Get('/')]
    public function index(): Response
    {
        return $this->display('Register', ['title' => 'Register']);
    }

    protected function display(string $page, array $args, string $url = "/login"): Response
    {
        return !isAuth() ?
            $this->render($page, $args) :
            $this->redirectBack($this->request);
    }

    #[Post('/')]
    public function register(): Response
    {
        $acc = AccountService::register(
            $this->buildForm()
        );

        if (is_null($acc) || !isset($acc->id)) {
            echo "oh oh :3";
            exit();
        }

        $this->connect($acc->id);

        return $this->redirect("/");
    }
}