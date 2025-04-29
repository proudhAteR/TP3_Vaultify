<?php

namespace Controllers\Authentication;

use Controllers\AppController;
use Zephyrus\Network\Response;

class AuthenticationController extends AppController
{
    protected function display(string $page, array $args, string $url = "/login"): Response
    {
        return !isAuth() ?
            $this->render($page, $args) :
            $this->redirectBack($this->request);
    }

    protected function connect(int $id): Response
    {
        $_SESSION["user"] = $id;
        return $this->redirect("/");
    }
}