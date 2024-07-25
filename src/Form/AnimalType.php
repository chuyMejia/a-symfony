<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class AnimalType extends AbstractType{

    public function buildForm(FormBuilderInterface $builder,array $options){

        $builder->add('tipo',TextType::class,[//input
            'label'=>'Type of animal'
            ])
         ->add('color',TextType::class)
         ->add('raza',TextType::class)
         ->add('tamano',TextType::class)
         ->add('submit',SubmitType::class,[//boton
            'label'=>'Create Animal',//atributo
            'attr'=>['class'=>'btn btn-success']
         ]);
       

    }
}