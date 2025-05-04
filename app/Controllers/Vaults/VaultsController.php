<?php

namespace Controllers\Vaults;

use Controllers\AppController;
use Models\Brokers\VaultBroker;
use Models\Entities\Vault;
use Models\Services\EncryptionService;
use Models\Services\VaultService;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Post;
use Zephyrus\Network\Router\Root;

#[Root('/vaults')]
class VaultsController extends AppController
{
    #[Get('/')]
    public function index(): Response
    {
        return $this->display(
            page: "vaults",
            args: [
                'title' => "Vaults",
                'vaults' => new VaultBroker()->find(),
                'decrypt' => function (string $pwd): string {
                    return EncryptionService::decrypt($pwd);
                }
            ]
        );
    }

    #[Post('/{vault_id}')]
    public function update(): Response
    {
        VaultService::update(
            $this->get_updated_vault(),
            $this->buildForm()
        );

        return $this->display(
            page: "vaults",
            args: [
                'title' => "Vaults",
                'vaults' => [$this->get_updated_vault()],
                'decrypt' => function (string $pwd): string {
                    return EncryptionService::decrypt($pwd);
                }
            ]
        );
    }

    private function get_updated_vault(): Vault
    {
        $id = $this->request->getArgument('vault_id');

        return VaultService::build_vault(
            new VaultBroker()->find_by_id($id)
        );
    }
}