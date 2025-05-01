<?php

namespace Controllers;

use Zephyrus\Core\Session;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Post;

class AppController extends Controller
{
    #[Post("/disconnect")]
    public function index(): Response
    {
        Session::remove("user");
        return $this->redirect("/login");
    }

    protected function display(string $page, array $args, string $url = "/login"): Response
    {
        return $this->isAuth() ? $this->render($page, $args) : $this->redirect($url);
    }

    protected function isAuth(): bool
    {
        return Session::get("user") !== null;
    }
}