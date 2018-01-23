<?php
/**
 * Created by PhpStorm.
 * User: skillup_student
 * Date: 12.01.18
 * Time: 23:09
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="order_items")
 */
class OrderItem
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *
     */
    private $id;

    /**
     * @var Order|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="items")
     * @ORM\JoinColumn(name="order_id", nullable=true, onDelete="CASCADE")
     */
    private $order;

    /**
     * @var Product|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     * @ORM\JoinColumn(name="product_id", nullable=true, onDelete="CASCADE")
     */
    private $product;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=20, scale=3)
     */
    private $count;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=20, scale=2)
     */
    private $amount;

    /**
     * OrderItem constructor.
     */
    public function __construct()
    {
        $this->count = 0;
        $this->amount = 0;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return OrderItem
     */
    public function setId(int $id): OrderItem
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return Order|null
     */
    public function getOrder(): ?Order
    {
        return $this->order;
    }

    /**
     * @param Order|null $order
     * @return OrderItem
     */
    public function setOrder(?Order $order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return Product|null
     */
    public function getProduct(): ?Product
    {
        return $this->product;
    }

    /**
     * @param Product|null $product
     * @return OrderItem
     */
    public function setProduct(?Product $product)
    {
        $this->product = $product;
        return $this;
    }

    /**
     * @return float
     */
    public function getCount(): float
    {
        return $this->count;
    }

    /**
     * @param float $count
     * @return OrderItem
     */
    public function setCount(float $count): OrderItem
    {
        $this->count = $count;
        $this->amount = $this->product->getPrice() * $count;
        $this->order->recalculateItems();

        return $this;
    }

    /**
     * @return float
     */
    public function getAmount(): float
    {
        return $this->amount;
    }

    /**
     * @param float $amount
     * @return OrderItem
     */
    public function setAmount(float $amount): OrderItem
    {
        $this->amount = $amount;
        return $this;
    }

    public function addCount(float $count): OrderItem
    {
        $this->count += $count;
        $this->setAmount($this->count * $this->product->getPrice());
        $this->order->recalculateItems();

        return $this;
    }


}