<?php

namespace Controllers\Vaults;

use Controllers\AppController;
use Models\Brokers\VaultBroker;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Root;
use Zephyrus\Security\Cryptography;

#[Root('/vaults')]
class VaultsController extends AppController
{
    #[Get('/')]
    public function index(): Response
    {
        $v = new VaultBroker()->find();

        return $this->display(
            "vaults",
            [
                'title' => "Vaults",
                'vaults' => $v,
                'f' => function (string $pwd): string {
                    return Cryptography::decrypt($pwd) ?? "";
                }
            ]
        );
    }
}