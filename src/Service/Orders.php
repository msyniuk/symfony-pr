<?php

namespace App\Service;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Orders
{

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * Orders constructor.
     */
    public function __construct(SessionInterface $session, EntityManagerInterface $em)
    {
        $this->session = $session;
        $this->em = $em;
    }


    public function getCurrentOrder(): Order
    {
        $id = $this->session->get('current_order_id');

        if ($id){
            $order = $this->em->find(Order::class, $id);
        } else {
            $order = null;
        }
        //$order = $id ? $this->em->find(Order::class, $id) : null;

        if (!$order || $order->getStatus() != Order::STATUS_DRAFT) {
            $order = new Order();
            $this->em->persist($order);
            $this->em->flush();
            $this->session->set('current_order_id', $order->getId());
        }
            return $order;
    }

    public function addProduct(Product $product, $count)
    {
        $order = $this->getCurrentOrder();

        $existingItem = null;

        foreach ($order->getItems() as $item){
            if ($item->getProduct()->getId() == $product->getId()){
                $existingItem = $item;
                break;
            }

        }

        if (!$existingItem){
            $existingItem = new OrderItem();
            $existingItem->setProduct($product);
            $order->addItem($existingItem);
            $this->em->persist($existingItem);
        }

        $existingItem->addCount($count);
        $this->em->flush();
    }

    public function removeItem(OrderItem $item)
    {
        $order = $this->getCurrentOrder();

        $order->removeItem($item);

        $this->em->remove($item);

        $order->recalculateItems();


        $this->em->flush();
    }

    public function makeOrder(Order $order)
    {
        $order->setStatus(Order::STATUS_ORDERED);
        $this->em->flush();

    }

}