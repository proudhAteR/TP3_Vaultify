<?php

namespace Controllers\Vaults;

use Controllers\AppController;
use Models\Brokers\VaultBroker;
use Models\Services\EncryptionService;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Root;
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
                    return EncryptionService::decrypt($pwd);
                }
            ]
        );
    }
}