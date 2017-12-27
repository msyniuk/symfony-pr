<?php

namespace App\Service;


use App\Entity\Category;
use App\Entity\Product;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class Catalogue
{
    /**
     * @var EntityManager
     */
    private $em;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * @return Category[]|array
     */
    public function getCategories()
    {
        $repo = $this->em->getRepository(Category::class);

        return $repo->findAll();


    }

    /**
     * @return Category[]|array
     */
    public function getTopCategories()
    {
        $repo = $this->em->getRepository(Category::class);

        return $repo->findBy(['parent' => null], ['name' => 'ASC']);
    }

    /**
     * @return Product[]\array
     */
    public function getTopProducts()
    {
        $repo = $this->em->getRepository(Product::class);

        return $repo->findBy(['isTop' => true], ['name' => 'ASC']);
    }
}