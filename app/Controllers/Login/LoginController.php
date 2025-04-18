<?php

namespace Controllers\Login;
use Controllers\Controller;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Post;
use Zephyrus\Network\Router\Root;

#[Root('/login')]
class LoginController extends Controller
{
    #[Get('/')]
    public function index() : Response {
        return $this->render('login', ['title' => 'Login']);
    }

    #[Post('/')]
    public function authenticate()
    {

    }
}