<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class About extends Controller
{
    public $shopName = '"SuperMag"';
    /**
     * @Route("/about")
     * @return Response
     */

    public function today(){
        $date = date('d.m.Y г., l');

        return $this->render('about.html.twig', array(
            'date' => $date, 'shopName' => $this->shopName,
        ));
    }
}