<?php


namespace App\Controller;


use App\Entity\Order;
use App\Entity\OrderItem;
use App\Entity\Product;
use App\Form\OrderType;
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

    /**
     * @Route("order/complete", name="order_complete")
     */
    public function completeOrder(Orders $orders, Request $request, \Swift_Mailer $mailer)
    {
        $order = $orders->getCurrentOrder();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $this->sendEmails($order, $mailer);
            $orders->makeOrder($order);
            $this->addFlash($order->getId(), 'last_order');

            return $this->redirectToRoute('order_success');
        }

        return $this->render('order/completeForm.html.twig', [
            'order' => $order,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("order/success", name="order_success")
     */
    public function successOrder()
    {
        return $this->render('order/success.html.twig');
    }

    private function sendEmails(Order $order, \Swift_Mailer $mailer){
        $message = (new \Swift_Message('Новый заказ на сайте'))
            ->setFrom([getenv('MAILER_FROM') => getenv('MAILER_FROM_NAME')])
            ->setTo(getenv('ADMIN_EMAIL'))
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'order/admin_message.html.twig',
                    array('order' => $order)
                ),
                'text/html'
            );
        $mailer->send($message);

        $message = (new \Swift_Message('Ваш заказ'))
            ->setFrom([getenv('MAILER_FROM') => getenv('MAILER_FROM_NAME')])
            ->setTo([$order->getEmail() => $order->getCustomerName()])
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'order/customer_message.html.twig',
                    array('order' => $order)
                ),
                'text/html'
            );
        $mailer->send($message);
    }
}