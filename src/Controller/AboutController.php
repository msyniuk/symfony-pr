<?php

namespace App\Controller;


use App\Form\FeedBackType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class AboutController extends Controller
{

    /**
     * @Route("/about", name="about_show")
     */
    public function show(SessionInterface $session)
    {
        $url = $this->generateUrl('category_show', [
            'slug' => 'notebooks',
            'param' => 'getparam',
        ], UrlGeneratorInterface::ABSOLUTE_URL);

        return $this->render('/about/about.html.twig', [
            'notebooksUrl' => $url,
            'lastCategory' => $session->get('lastVisitedCategory')
        ]);
    }

    /**
     * @Route("/to-about")
     */
    public function redirectToShow()
    {
        return $this->redirectToRoute('about_show');
    }

    /**
     * @Route("/feedback", name="feedback")
     *
     * @param Request $request
     */
    public function feedback(Request $request)
    {
        $form = $this->createForm(FeedBackType::class);

        return $this->render('about/feedback.html.twig', [
            'form' => $form->createView(),
        ]);
    }


}