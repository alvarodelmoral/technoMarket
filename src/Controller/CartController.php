<?php

// src/Controller/CartController.php
namespace App\Controller;

use App\Entity\Producto;
use App\Entity\CartContent;
use Symfony\Component\Security\Core\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{

    public function addAction(Security $security, $idProduct, $quantity)
    {

        $user = $security->getUser();


        $entityManager = $this->getDoctrine()->getManager();

        $producto = $entityManager->getRepository(Producto::class)->find($idProduct);

        $cartContent = new CartContent();

        $cartContent->setProducto($producto);
        $cartContent->setQuantity($quantity);

        $user->getCart()->addContent($cartContent);

        $entityManager->persist($cartContent);
        $entityManager->flush();

        $this->addFlash(
            'success',
            'Producto añadido al carrito.'
        );

        return $this->redirect($this->generateUrl('carrito'));
    }

    public function removeAction($idCartContent)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $cartContent = $entityManager->getRepository(CartContent::class)->find($idCartContent);

        if (!$cartContent) {

            throw $this->createNotFoundException(
                'No existe ningun producto con id ' . $idCartContent
            );
        }

        $entityManager->remove($cartContent);

        $entityManager->flush();

        $this->addFlash(
            'success',
            'Producto eliminado del carrito.'
        );

        return $this->redirect($this->generateUrl('carrito'));
    }
}