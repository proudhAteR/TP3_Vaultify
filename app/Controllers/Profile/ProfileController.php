<?php namespace Controllers\Profile;

use Controllers\Controller;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;
use Zephyrus\Network\Router\Root;

#[Root('/profile')]
class ProfileController extends Controller
{
    #[Get('/')]
    public function index(): Response
    {
        return $this->render("profile", ['title' => 'Profile']);
    }
}