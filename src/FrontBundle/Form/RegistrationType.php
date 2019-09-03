<?php
// src/AppBundle/Form/RegistrationType.php

namespace FrontBundle\Form;
use FrontBundle\Form\StringToArrayTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\PropertyAccess\PropertyPath;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use BackBundle\Entity\Categories;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
class RegistrationType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
    {

      
        $builder 



























      ->add('civilite', ChoiceType::class, array(
    'choices'  => array(
        'Homme' => 'Homme',
        'Femme' => 'Femme'
       
    ),
      
     'attr' => array('class'=>'form-control','placeholder'=>'Civilite','required'=>true ,'property_path' => false,
     'multiple'  => false,
      'placeholder' => 'Civilite',
     

     

), 'constraints' => [new NotBlank(['message' => 'Le champs civilite ne doit pas etre vide'])]

   ))

   ->add('ville', ChoiceType::class, array(
    'choices'  => array(
        'Tunis' => 'Tunis',
        'Manouba' => 'Manouba',
        'Ariana' => 'Ariana',
        'Ben arous' => 'Ben arous'
       
    ),
      
     'attr' => array('class'=>'form-control','placeholder'=>'Ville','required'=>true ,'property_path' => false),

     'multiple'  => false,
      'placeholder' => 'Ville'

     

))








    ->add('prenom', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Prenom'


  ), 'constraints' => [new NotBlank(['message' => 'Le champs prenom ne doit pas etre vide'])]

  )

  )
    ->add('nom', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Nom'), 'constraints' => [new NotBlank(['message' => 'Le champs nom ne doit pas etre vide'])]))
   
   ->add('adresse', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Adresse')))
    ->add('cp', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Cp')))

     ->add('telephone', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Telephone')));









 
    }

    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\RegistrationFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    public function getBlockPrefix()
    {
        return 'app_user_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }	




















}