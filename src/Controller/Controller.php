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

        // $email = $_POST['email'];
        // $nombre = $_POST['nombre'];
        // $direccion = $_POST['direccion'];
        // $asunto = $_POST['asunto'];
        // $mensaje = $_POST['mensaje'];

        // $header = 'From: ' . $email . " \r\n";
        // $header .= "X-Mailer: PHP/" . phpversion() . " \r\n";
        // $header .= "Mime-Version: 1.0 \r\n";
        // $header .= "Content-Type: text/plain";

        // $mensaje = "Este mensaje fue enviado por " . $nombre . ",\r\n";
        // $mensaje .= "Su e-mail es: " . $email . " \r\n";
        // $mensaje .= "Desde: " . $_POST['direccion'] . " \r\n";
        // $mensaje .= "Mensaje: " . $_POST['mensaje'] . " \r\n";
        // $mensaje .= "Enviado el " . date('d/m/Y', time());

        // $para = 'vetmenor@gmail.com';

        // mail($para, $asunto, utf8_decode($mensaje), $header);

        // header("Location:inicio.html.twig");

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

    public function editarProducto(Request $request, $id)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $producto = $entityManager->getRepository(Producto::class)->find($id);

        $form = $this->createFormBuilder($producto)
            ->add('Nombre', TextType::class)
            ->add('Color', TextType::class)
            ->add('Memoria', TextType::class)
            ->add('Descripcion', TextareaType::class)
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
                'notice2',
                'Tus cambios se han guardado!'
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
            'notice3',
            'Tus cambios se han guardado!'
        );

        return $this->redirect($this->generateUrl('productos'));
    }
}