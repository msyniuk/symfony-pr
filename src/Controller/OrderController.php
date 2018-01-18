<?php


namespace App\Controller;


use App\Entity\OrderItem;
use App\Entity\Product;
use App\Service\Orders;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends Controller
{
    /**
     * @Route("order/add-product/{id}/{count}", name="order_add_product",
     *     requirements={"id": "\d+", "count": "\d+(\.\d+)?"})
     */
    public function addProduct(Product $product, $count, Orders $orders, Request $request)
    {
        $orders->addProduct($product, $count);

        return $this->redirect($request->headers->get('referer'));
    }

    /**
     * @Route("order/remove-item/{id}", name="order_remove_item",
     *     requirements={"id": "\d+"})
     */
    public function removeItem(OrderItem $item, Orders $orders)
    {
        $orders->removeItem($item);

        return $this->redirectToRoute('order_cart');
    }

    /**
     * @Route("cart", name="order_cart")
     */
    public function showCart(Orders $orders)
    {
        return $this->render(
            'order/cart.html.twig',
            ['order' => $orders->getCurrentOrder()]
            );
    }
}