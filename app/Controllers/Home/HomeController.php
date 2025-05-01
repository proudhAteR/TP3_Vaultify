<?php namespace Controllers\Home;

use Controllers\AppController;
use Models\Brokers\VaultBroker;
use Models\Services\AccountService;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;

class HomeController extends AppController
{
    #[Get("/")]
    public function index(): Response
    {
        return $this->display(
            "home",
            [
                "title" => "Home",
                "username" => AccountService::getUser()?->username,
                "vaults" => new VaultBroker()->find() ?? [],
            ]
        );
    }
}