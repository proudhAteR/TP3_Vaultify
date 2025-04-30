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
        //TODO: User profile picture from the assets using the path
        $username = AccountService::getUser()->username ?? "";
        $vaults = new VaultBroker()->find() ?? [];
        return $this->display(
            "home",
            [
                "title" => "Home",
                "username" => $username,
                "vaults" => $vaults,
            ]
        );
    }
}