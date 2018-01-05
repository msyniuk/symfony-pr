<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string

     * @ORM\Column(type="string", length=250)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=250, unique=true)
     */
    private $slug;

    /**
     * @var Product[]|ArrayCollection
     * @ORM\OneToMany(targetEntity="App\Entity\Product", mappedBy="category")
     */
    private $products;
    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     * @ORM\JoinColumn(name="parent_id", onDelete="CASCADE")
     */
    private $parent;

    /**
     * @var Category[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Category", mappedBy="parent")
     */
    private $subcategories;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Category
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): ? string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Category
     */
    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSlug(): ? string
    {
        return $this->slug ?: '';
    }

    /**
     * @param string $slug
     * @return Category
     */
    public function setSlug(string $slug): Category
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return Product[]|ArrayCollection
     */
    public function getProducts()
    {
        return $this->products;
    }

    public function addProduct(Product $product)
    {
        $this->products->add($product);
        $product->setCategory($this);

        return $this;
    }

    public function removeProduct(Product $product)
    {
        $this->products->removeElement($product);

        return $this;
    }

    public function getFullName()
    {
        $ret = [];

        if ($this->parent) {
            $parent = $this->parent;

            while ($parent){
                $ret[] = $parent->name;
                $parent = $parent->parent;
            }
        }

        $ret[] = $this->name;

        return implode(' / ', $ret);
    }

    public function __toString()
    {
        return $this->getFullName() ?: '';
    }

    /**
     * @return Category
     */
    public function getParent(): ? Category
    {
        return $this->parent;
    }

    /**
     * @param Category $parent
     * @return Category
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Category[]|ArrayCollection
     */
    public function getSubcategories()
    {
        return $this->subcategories;
    }

    /**
     * @param Category[]|ArrayCollection $subcategories
     * @return Category
     */
    public function setSubcategories($subcategories)
    {
        $this->subcategories = $subcategories;
        return $this;
    }

}
