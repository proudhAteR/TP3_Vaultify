<?php

namespace Controllers;

use Models\Entities\Account;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Post;

class AppController extends Controller
{
    #[Post("/disconnect")]
    public function disconnect(): Response
    {
        unset($_SESSION["user"]);

        return $this->redirect("/login");
    }

    protected function display(string $page, array $args, string $url = "/login"): Response
    {
        return isAuth() ? $this->render($page, $args) : $this->redirect($url);
    }

    protected function connect(int $id): void
    {
        $_SESSION["user"] = $id;
    }
}