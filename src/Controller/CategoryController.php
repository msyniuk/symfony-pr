<?php

namespace App\Controller;


use App\Entity\Category;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CategoryController extends Controller
{

    /**
     * @Route("/category/{slug}/{page}", name="category_show",
     * requirements={"page": "\d+"})
     *
     * @ParamConverter("slug", options={"mapping": {"slug": "slug"}})
     *
     * @param Category $category
     * @param $page
     * @param $session
     *
     * @return Response
     */
    public function show(Category $category, $page = 1, SessionInterface $session)
    {
        $session->set('lastVisitedCategory', $category->getId());

        return $this->render(
            'category/show.html.twig',
            ['category' => $category, 'page' => $page]
        );
    }

    /**
     * @Route("message", name="category_message")
     */
    public function message(SessionInterface $session)
    {
        $this->addFlash('notice', 'Successfully added!');
        $lastCategory= $session->get('lastVisitedCategory');

        return $this->redirectToRoute('category_show', ['id' => $lastCategory]);
    }

    /**
     * @Route("download", name="category_download")
     */
    public function fileDownload()
    {
        $response = new Response();
        $response->setContent('Test content');

        return $response;
    }

    /**
     * @Route("/categories/{name}", name="categories_list")
     */
    public function listCategories($name = '')
    {
        $repo = $this->getDoctrine()->getRepository(Category::class);
        //$product = $repo->findOneBy(['name' => $name]);
        //$product = $repo->findOneByName($name);
        if ( $name ) {
            $categories = $repo->findBy(['name' => $name]);
        } else {
            $categories = $repo->findAll();
        }

        if ( !$categories ) {
            return $this->createNotFoundException('Categories not found');
        }

        return $this->render('category/list.html.twig', ['categories' => $categories]);
    }

}