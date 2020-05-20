<?php

// src/Controller/CartController.php
namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Producto;
use App\Entity\CartContent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class CartController extends AbstractController
{

    // public function addAction(Request $request)
    // {

    //     $cart = Cart::add(
    //         $request->request->get('producto'),
    //         (int) $request->request->get('quantity')
    //     );
    //     return new JsonResponse(array('total' => $cart->total, 'count' => $cart->count));
    // }

    // public function indexAction(Request $request)
    // {
    //     $cart = Cart::get();
    //     $categories = Category::findAll();
    //     return $this->render('store/cart.html.twig', [
    //         'categories' => $categories, 'cart' => $cart
    //     ]);
    // }

    // public function removeAction(Request $request, $id)
    // {
    //     $cart = Cart::removeItem($id);
    //     return new JsonResponse(array('total' => $cart->total, 'count' => $cart->count));
    // }

}