<?php namespace Controllers\Home;

use Controllers\Controller;
use Models\Services\AccountService;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;

class HomeController extends Controller
{
    #[Get("/")]
    public function index(): Response
    {
        $username = AccountService::getUser()->username ?? "";

        return $this->display(
            "home",
            [
                "title" => "Home",
                "username" => $username
            ]
        );
    }
}