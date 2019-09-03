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
use Symfony\Component\Validator\Constraints\NotBlank;


use FOS\UserBundle\Form\Type\RegistrationFormType;
class RegistrationFournisseurType extends AbstractType
{

  public function buildForm(FormBuilderInterface $builder, array $options)
    {

      
        $builder 



























      ->add('fonction', ChoiceType::class, array(
    'choices'  => array(
        'Farmer' => 'Farmer',
        'Grousiste' => 'Grousiste')
       
    ,
      
     'attr' => array('class'=>'form-control','placeholder'=>'Fonction','required'=>true ,'property_path' => false,
     'multiple'  => false,
      'placeholder' => 'Fonction')

     

, 'constraints' => [new NotBlank(['message' => 'Le champs fonction ne doit pas etre vide'])]))

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


    
    ->add('responsable', null, array('attr'=>array('class'=>'form-control','placeholder'=>'Responsable'), 'constraints' => [new NotBlank(['message' => 'Le champs responsable ne doit pas etre vide'])]))
    
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
        return 'app_user_fournisseur_registration';
    }

    // For Symfony 2.x
    public function getName()
    {
        return $this->getBlockPrefix();
    }	
}