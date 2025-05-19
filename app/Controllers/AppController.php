<?php

namespace Controllers;

use Models\Core\Passport;
use Zephyrus\Network\Response;

class AppController extends Controller
{
    protected function display(string $page, array $args, string $url = "/login"): Response
    {
        return $this->isAuth() ? $this->render($page, $args) : $this->redirect($url);
    }

    public static function isAuth(): bool
    {
        return Passport::isAuthenticated();
    }

    protected function go_back(): Response
    {
        return $this->redirectBack($this->request);
    }
}