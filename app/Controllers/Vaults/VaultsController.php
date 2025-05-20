<?php

namespace Controllers\Vaults;

use Controllers\AppController;
use Models\Brokers\VaultBroker;
use Models\Entities\Vault;
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
            args: ['title' => "Vaults"]
        );
    }

    #[Post('/create')]
    public function create(): Response
    {
        VaultService::create(
            $this->buildForm()
        );

        return $this->go_back();
    }

    #[Post('/{vault_id}')]
    public function update(): Response
    {
        VaultService::update(
            $this->get_updated_vault(),
            $this->buildForm()
        );

        return $this->go_back();
    }

    #[Post('/delete/{vault_id}')]
    public function delete(int $id): Response
    {
        VaultService::delete($id);

        return $this->go_back();
    }

    private function get_updated_vault(): Vault
    {
        $id = $this->request->getArgument('vault_id');

        return VaultService::build_vault(
            new VaultBroker()->find_by_id($id)
        );
    }
}