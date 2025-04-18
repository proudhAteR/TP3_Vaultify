<?php namespace Controllers\Profile;

use Controllers\Controller;
use Zephyrus\Network\Response;
use Zephyrus\Network\Router\Get;

class ProfileController extends Controller
{
    #[Get('/profile')]
    public function index(): Response
    {
        return $this->render("profile", ['title' => 'Test']);
    }
}