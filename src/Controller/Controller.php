<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Producto;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;

class Controller extends AbstractController
{

    public function indice()
    {
        return $this->render('inicio.html.twig');
    }

    public function contacto()
    {
        return $this->render('contacto.html.twig');
    }

    public function productos()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $productos = $entityManager->getRepository(Producto::class)->findAll();

        return $this->render('productos.html.twig', array(
            'productos' => $productos,
        ));
    }

    public function servicios()
    {
        return $this->render('servicios.html.twig');
    }

    public function carrito()
    {
        $entityManager = $this->getDoctrine()->getManager();

        $productos = $entityManager->getRepository(Producto::class)->findAll();

        return $this->render('carrito.html.twig', array(
            'productos' => $productos,
        ));
    }


    public function verProducto($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $producto = $entityManager->getRepository(Producto::class)->find($id);

        if (!$producto) {
            throw $this->createNotFoundException(
                'No existe ningun producto con id ' . $id
            );
        }

        return $this->render('producto.html.twig', array(
            'producto' => $producto,
        ));
    }

    public function creadoProducto()
    {
        return $this->render('productoCreado.html.twig');
    }

    public function editarProducto(Request $request, $id)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $producto = $entityManager->getRepository(Producto::class)->find($id);

        $form = $this->createFormBuilder($producto)
            ->add('Nombre', TextType::class)
            ->add('Color', TextareaType::class)
            ->add('Memoria', TextareaType::class)
            ->add('Descripcion', TextareaType::class)
            ->add('Precio', TextareaType::class)
            ->add(
                'Guardar',
                SubmitType::class,
                array('label' => 'Editar Producto')
            )
            ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $producto = $form->getData();

            $entityManager->flush();

            return $this->redirectToRoute('productos', array('id' => $id));
        }

        return $this->render('nuevoProducto.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function borrarProducto($id)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $producto = $entityManager->getRepository(Producto::class)->find($id);

        if (!$producto) {

            throw $this->createNotFoundException(
                'No existe ningun producto con id ' . $id
            );
        }

        $entityManager->remove($producto);

        $entityManager->flush();

        return $this->render('borrarProducto.html.twig');
    }
}