<?php

namespace Controllers;

use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Post;

class AppController extends Controller
{
    #[Post("/disconnect")]
    public function index(): Response
    {
        unset($_SESSION["user"]);
        return $this->redirect("/login");
    }

    protected function display(string $page, array $args, string $url = "/login"): Response
    {
        return isAuth() ? $this->render($page, $args) : $this->redirect($url);
    }
}