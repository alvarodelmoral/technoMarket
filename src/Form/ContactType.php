<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                TextType::class,
                array(
                    'label' => false,
                )
            )
            ->add(
                'nombre',
                TextType::class,
                array(
                    'label' => false,
                )
            )
            ->add(
                'direccion',
                TextType::class,
                array(
                    'label' => false,
                )
            )
            ->add(
                'asunto',
                ChoiceType::class,
                [
                    'choices'  => [
                        ' ' => '',
                        'Devoluciones' => 'devoluciones',
                        'Garantías' => 'garantias',
                        'Envíos' => 'envios',
                        'Otros' => 'otros',
                    ],
                    'label' => false,
                ],
            )
            ->add(
                'mensaje',
                TextareaType::class,
                array(
                    'label' => false,
                )
            )
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Debes aceptar los términos de uso.',
                    ]),
                ],
                'label' => "Acepto los términos",
            ])
            ->add(
                'enviar',
                SubmitType::class,
                array('label' => 'Enviar')
            );
    }

    public function getName()
    {
        return 'contacto';
    }
}