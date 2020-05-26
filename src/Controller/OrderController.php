<?php

// src/Controller/OrderController.php
namespace App\Controller;

use App\Entity\Order;
use App\Entity\OrderContent;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class OrderController extends AbstractController
{

    public function addAction(Security $security, \Swift_Mailer $mailer)
    {

        $user = $security->getUser();

        $cart = $user->getCart();

        $order = new Order();
        $order->setUser($user);
        $order->setCreationDate(new \DateTime('now'));
        $order->setTotal($cart->getTotal());

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($order);


        foreach ($cart->getContent() as $cartContent) {

            $orderContent = new OrderContent();
            $orderContent->setPedido($order);
            $order->addContent($orderContent);
            $orderContent->setQuantity($cartContent->getQuantity());
            $orderContent->setProducto($cartContent->getProducto());

            $entityManager->persist($orderContent);

            $cart->removeContent($cartContent);
            $entityManager->remove($cartContent);
        }

        $entityManager->flush();

        $cuerpoMensaje =
            "<p>Este es un nuevo pedido tramitado por un cliente a la espera
         de un pago por transferencia.</p>
         <p>Cliente: " . $user->getEmail() . "</p></br>
         <p>Pedido: " . $order->getId() . "</p></br>
         <p>Contenido: </p><ul>";

        foreach ($order->getContent() as $orderContent) {
            $cuerpoMensaje .=  "<li>" . $orderContent->getQuantity() . ": " . $orderContent->getProducto()->getNombre() . "</li>";
        }

        $cuerpoMensaje .= "</ul>";

        $message = (new \Swift_Message('Pedido tramitado desde un cliente.'))
            ->setSubject("Nuevo pedido")
            ->setFrom($_ENV["EMAIL"])
            ->setTo($_ENV["EMAIL"])
            ->setBody(
                $cuerpoMensaje,
                'text/html'
            );

        $mailer->send($message);


        return $this->render('pedidoRealizado.html.twig', array(
            'numeroCuenta' => $_ENV["NUMEROCUENTA"],
            'totalPagar' => $order->getTotal(),
            'concepto' => $order->getId()
        ));
    }
}