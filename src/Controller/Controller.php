<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Producto;
use App\Form\ContactType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;


class Controller extends AbstractController
{

    public function indice()
    {
        return $this->render('inicio.html.twig');
    }

    public function contacto(Request $request,  \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ContactType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $message = (new \Swift_Message('Saludos, este es un mensaje de un cliente'))
                ->setSubject($form->getData()['asunto'])
                ->setFrom($_ENV["EMAIL"])
                ->setTo($_ENV["EMAIL"])
                ->setBody(
                    'Email: ' . $form->getData()['email'] .
                        "\n" . 'Asunto: ' . $form->getData()['asunto'] .
                        "\n" . 'Mensaje: ' . $form->getData()['mensaje'],
                    'text/plain'
                );

            $mailer->send($message);

            $this->addFlash(
                'success',
                'Mensaje enviado con éxito.'
            );
        }

        return $this->render('contacto.html.twig', [
            'contacto' => $form->createView(),
        ]);
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

    public function editarProducto(Request $request, $id)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $producto = $entityManager->getRepository(Producto::class)->find($id);

        $form = $this->createFormBuilder($producto)
            ->add('Nombre', TextType::class)
            ->add('Color', TextType::class)
            ->add('Memoria', TextType::class)
            ->add(
                'Descripcion',
                TextareaType::class,
                array(
                    'required' => true,
                    'attr' => ['maxlength' => 120]
                )
            )
            ->add('Precio', TextType::class)
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

            $this->addFlash(
                'success',
                'Producto editado con éxito.'
            );

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

        $this->addFlash(
            'success',
            'Producto borrado con éxito.'
        );

        return $this->redirect($this->generateUrl('productos'));
    }

    public function menu(Security $security, $seccionActual)
    {
        $user = $security->getUser();

        $cantidadProductos = 0;

        if ($this->isGranted('ROLE_USER')) {
            $cantidadProductos = $user->getCart()->getCantidadProductos();
        }

        return $this->render('menu.html.twig', array(
            'seccionActual' => $seccionActual,
            'cantidadProductos' => $cantidadProductos
        ));
    }
}