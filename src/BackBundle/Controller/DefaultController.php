<?php

namespace BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use PDO;

class DefaultController extends Controller
{
   


   /**
     * @Route("/user/home/profile-client",name="modifier_profile_client")
     */
    public function modifierProfileClientAction(Request $request)
    {
 $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $anciennlogo=$user->getPhoto();
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {



           $form=$this->createFormBuilder($user)
->add('nom',TextType::Class)
->add('prenom',TextType::Class)
->add('username',TextType::Class)
->add('email',TextType::Class)
->add('telephone',TextType::Class)
->add('adresse',TextType::Class)
->add('cp',TextType::Class)
 ->add('ville', ChoiceType::class, array(
    'choices'  => array(
           'Tunis' => 'Tunis',
        'Manouba' => 'Manouba',
        'Ariana' => 'Ariana',
        'Ben arous' => 'Ben arous'
  
    ),
      
     'attr' => array('required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'Ville'

     

))


->add('civilite', ChoiceType::class,
            [
                'label' => 'Civilisation :',
                'required' => true,
                'choices' => array(
                    'Homme' => 'Homme',
                    'Femme' => 'Femme'
                    
                   
                ),
                'placeholder' => '--Select Civilisation--',
            ]
        )


->add('photo', FileType::class, array('label' => 'Votre Image','data_class' => null))

->getForm();
$form->handleRequest($request);
if($form->isSubmitted() ){
if( $form->isValid()){

           if($form['photo']->getData() != null)
       {
          $file =$form['photo']->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('logo_directory'),
                $fileName
            );

         $user->setPhoto($fileName);
     }else{

     $user->setPhoto($anciennlogo);
 }

//$userManager = $container->get('fos_user.user_manager');
 $this->get('fos_user.user_manager')->updateUser($user, false);

        // make more modifications to the database

        $this->getDoctrine()->getManager()->flush();

       
        if($request->isXmlHttpRequest())
                     {

                        $msg='Compte Modifier Successfely';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg));

                     }

    }elseif($request->isXmlHttpRequest())
             {

                $formErrors=$this->get('validator')->validate($form);
                $errorsArray=[];

                foreach ($formErrors  as $error) {
                    
                    $errorsArray[]=array(
                       'elementId'=>$error->getPropertyPath(),
                       'errorMessage'=>$error->getMessage(),

                      
                    );

                }

                $msg="vouillez rensigner tous les champs";
                $response=new JsonResponse(['success'=>false,'message'=>$msg,'errors'=>$errorsArray]);
             }

      return $response;
    }





      
       return $this->render('BackBundle:Client:profile.html.twig',['form'=>$form->createView(),'user'=>$user]);  

    }else{
    	 $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));  
    }
}






   /**
     * @Route("/user/home/profile-fournisseur",name="modifier_profile_fournisseur")
     */
    public function modifierProfileFournisseurAction(Request $request)
    {
 $user = $this->container->get('security.token_storage')->getToken()->getUser();
       $anciennlogo=$user->getLogo();
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {



    $form=$this->createFormBuilder($user)
->add('responsable',TextType::Class)
->add('username',TextType::Class)
->add('email',TextType::Class)
->add('telephone',TextType::Class)
->add('adresse',TextType::Class)
->add('cp',NumberType::Class)
 ->add('ville', ChoiceType::class, array(
    'choices'  => array(
           'Tunis' => 'Tunis',
        'Manouba' => 'Manouba',
        'Ariana' => 'Ariana',
        'Ben arous' => 'Ben arous'
  
    ),
      
     'attr' => array('required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'Ville'

     

))

 ->add('fonction', ChoiceType::class, array(
    'choices'  => array(
            'Farmer' => 'Farmer',
        'Grousiste' => 'Grousiste'
  
    ),
      
     'attr' => array('required'=>true ,'property_path' => false),
     'multiple'  => false,
      'placeholder' => 'Fonction'

     

))





->add('logo', FileType::class, array('label' => 'Votre Image','data_class' => null))

->getForm();
$form->handleRequest($request);
if($form->isSubmitted() ){
if( $form->isValid()){

           if($form['logo']->getData() != null)
       {
          $file =$form['logo']->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('logo_directory'),
                $fileName
            );

         $user->setLogo($fileName);
     }else{

     $user->setLogo($anciennlogo);
 }

//$userManager = $container->get('fos_user.user_manager');
 $this->get('fos_user.user_manager')->updateUser($user, false);

        // make more modifications to the database

        $this->getDoctrine()->getManager()->flush();

       
        if($request->isXmlHttpRequest())
                     {

                        $msg='Compte Modifier Successfely';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg));

                     }

    }elseif($request->isXmlHttpRequest())
             {

                $formErrors=$this->get('validator')->validate($form);
                $errorsArray=[];

                foreach ($formErrors  as $error) {
                    
                    $errorsArray[]=array(
                       'elementId'=>$error->getPropertyPath(),
                       'errorMessage'=>$error->getMessage(),

                      
                    );

                }

                $msg="vouillez rensigner tous les champs";
                $response=new JsonResponse(['success'=>false,'message'=>$msg,'errors'=>$errorsArray]);
             }

      return $response;
    }













      return $this->render('BackBundle:Fournisseur:profile.html.twig',['form'=>$form->createView(),'user'=>$user]);   


    }else{
    	 $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));  
    }
}
   
}
