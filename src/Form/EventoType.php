<?php

namespace App\Form;

use App\Entity\Disertante;
use App\Entity\Evento;
use App\Entity\Usuario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titulo', null,[
                'label'=> 'Nombre',
                'attr' => [
                    'placeholder' => 'Ingrese el nombre del evento'
                ],
            ])
            ->add('descripcion', null, [
                'label' => 'Descripción',
                'attr' => [
                    'placeholder' => 'Ingrese una descripción',
                ],
            ])
            ->add('fecha')
            ->add('hora')
            ->add('duracion')
            ->add('idioma',  null, [
                'label' => 'Idioma',
                'attr' => [
                    'placeholder' => 'Ingrese el idioma',
                ],
            ])
            ->add('estado',  null, [
                'label' => 'Estado',
                'attr' => [
                    'placeholder' => 'Estado del Evento',
                ],
            ])
            ->add('disertante', EntityType::class, [
                'class' => Disertante::class,
                'choice_label' => 'nombre',
            ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Evento::class,
        ]);
    }
}
