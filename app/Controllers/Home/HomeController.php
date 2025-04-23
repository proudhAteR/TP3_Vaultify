<?php namespace Controllers\Home;

use Controllers\Controller;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;

class HomeController extends Controller
{
    #[Get("/")]
    public function index(): Response
    {
        return $this->display("home", ["title" => "Home"]);
    }
}