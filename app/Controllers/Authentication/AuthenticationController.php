<?php

namespace Controllers\Authentication;

use Controllers\AppController;
use Models\Entities\Account;
use Models\Services\AccountService;
use Zephyrus\Core\Session;
use Zephyrus\Network\Response;

class AuthenticationController extends AppController
{
    protected function display(string $page, array $args, string $url = "/login"): Response
    {
        return !$this->isAuth() ?
            $this->render($page, $args) :
            $this->redirectBack($this->request);
    }

    protected function connect(Account $acc): Response
    {
        AccountService::connect($acc);
        return $this->redirect("/");
    }
}