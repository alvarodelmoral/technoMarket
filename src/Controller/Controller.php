<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Ordenador;
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
        return $this->render('productos.html.twig');
    }

    public function servicios()
    {
        return $this->render('servicios.html.twig');
    }


    public function ordenador($id)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $ordenador = $entityManager->getRepository(Ordenador::class)->find($id);

        if(!$ordenador) {
            throw $this->createNotFoundException(
                'No existe ningun producto con id '.$id
            );
        }

        return $this->render('productos.html.twig', array(
            'ordenador' => $ordenador,
        ));

    }

    public function producto_nuevo(Request $request) 
    {
        $ordenador = new Ordenador();

        $form = $this->createFormBuilder($ordenador)            
            ->add('Nombre', TextType::class)            
            ->add('Procesador', TextareaType::class)  
            ->add('Memoria', TextareaType::class) 
            ->add('Precio', TextareaType::class)              
            ->add('Guardar', SubmitType::class,
                array('label' => 'Añadir Producto'))            
            ->getForm();

        $form -> handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $ordenador = $form->getData();
            
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($ordenador);

            $entityManager->flush();

            return $this->redirectToRoute('producto_ver');
        }
            
            return $this->render('productos.html.twig', array(
                'form' => $form->createView(),        
            ));
    }

    public function noticiaCreada()
    {
        return $this->render('noticiaCreada.html.twig');
    }

    public function editarNoticia(Request $request, $id)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $noticia = $entityManager->getRepository(Noticia::class)->find($id);

        $form = $this->createFormBuilder($noticia)
        ->add('titular', TextType::class)            
        ->add('entrada', TextareaType::class)  
        ->add('cuerpo', TextareaType::class)              
        ->add('save', SubmitType::class,
            array('label' => 'Editar Noticia'))            
        ->getForm();

            $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){

            $noticia = $form->getData();

            $entityManager->flush();

            return $this->redirectToRoute('noticia', array('id'=>$id));

        }

        return $this->render('nuevaNoticia.html.twig', array(
            'form' => $form->createView(),
        ));

    }

    public function borrarNoticia($id)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $noticia = $entityManager->getRepository(Noticia::class)->find($id);

        if (!$noticia){

            throw $this->createNotFoundException(
                'No existe ninguna noticia con id '.$id
            );

        }

        $entityManager->remove($noticia);

        $entityManager->flush();

        return $this->render('borrarNoticia.html.twig');

    }
}