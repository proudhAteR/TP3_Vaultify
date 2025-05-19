<?php

namespace Controllers\Authentication;

use Controllers\AppController;
use Models\Entities\Account;
use Models\Services\AccountService;
use Zephyrus\Application\Form;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Post;

class AuthenticationController extends AppController
{
    protected function display(string $page, array $args, string $url = "/login"): Response
    {
        return !$this->isAuth() ? $this->render($page, $args) : $this->go_back();
    }

    protected function connect(Account $acc, Form $form): Response
    {
        AccountService::connect($acc, $form);
        return $this->redirect("/");
    }

    #[Post("/disconnect")]
    public function disconnect(): Response
    {
        AccountService::disconnect();
        return $this->redirect("/login");
    }
}