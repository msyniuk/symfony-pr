<?php

namespace App\Controller;

use App\Service\Catalogue;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class DefaultController extends Controller
{

    /**
     * @Route("/", name="homepage")
     */
    public function show(Catalogue $catalogue)
    {
        return $this->render('/default/index.html.twig',
            ['topProducts' => $catalogue->getTopProducts()]);
    }

    /**
     * @Route("/to-about")
     */
    public function redirectToShow()
    {
        return $this->redirectToRoute('about_show');
    }

}