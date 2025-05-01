<?php

namespace Controllers\Profile;

use Controllers\AppController;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Root;

#[Root('/profile')]
class ProfileController extends AppController
{
    #[Get('/')]
    public function index(): Response
    {
        return $this->display("profile", ["title" => "Profile"]);
    }
}