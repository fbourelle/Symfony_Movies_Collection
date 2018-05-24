<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * préfixe l'url de toutes les routes de ce fichier
 *
 * @Route("/admin")
 */
class AdminController extends Controller
{
    /**
     * @Route("/home", name="admin_home")
     */
    public function adminHome()
    {
        return $this->render("admin/index.html.twig");
    }

}
