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
use BackBundle\Entity\Offre;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use PDO;

class OffreController extends Controller
{
  




     /**
     * @Route("/user/home/create-offre",name="create_offre")
     */
    public function addoffreAction(Request $request)
    {

      $entityManager = $this->getDoctrine()->getManager();

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     
          $offre = new Offre();

    $form = $this->createFormBuilder($offre)
        ->add('titre', TextType::class)
         ->add('description', TextareaType::class)
      








          

          ->add('prix', MoneyType::class)
           ->add('quantite', NumberType::class)

         // ->add('prix',TextType::class)
  

          
             ->add('tiket', NumberType::class)
          
               ->add('image', FileType::class)



        
        ->getForm();

    $form->handleRequest($request);

    if ($form->isSubmitted()) {

       if  ($form->isValid())
         {

       if($form['image']->getData() != null)
       {
          $file =$form['image']->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('logo_directory'),
                $fileName
            );

         $offre->setImage($fileName);




     }

     
$tiket=$form['tiket']->getData();
$quantite=$form['quantite']->getData();

$disponible=intval($quantite/$tiket);


$prod=$request->request->get('produit-offre');
 



         $prods = $entityManager->getRepository('BackBundle:Produit')->find($prod);

$cat=$request->request->get('categorie-select');
 



         $cats = $entityManager->getRepository('BackBundle:Categories')->find($cat);

$offre->setProduit($prods);
$offre->setCategorie($cats);
$offre->setUser($user);
$offre->setDisponible($disponible);
 $offre->setDatePublication(new \DateTime());




      $entityManager->persist($offre);


      $entityManager->flush();



     

      if($request->isXmlHttpRequest())
                     {

                        $msg='Offre ajouter a succèssffly ! ';
                        $response=new JsonResponse(array('success'=>true,'message'=>$msg));

                     }


}

     else{

        if($request->isXmlHttpRequest())
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

          }




      return $response;
    


    }
       


$categories = $entityManager->getRepository('BackBundle:Categories')->findAll();

    return $this->render('BackBundle:Fournisseur:addoffre.html.twig', [
        'form' => $form->createView(),'categories'=>$categories
    ]);  


    }
    else{
       $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
    }



}



   


   /**
     * @Route("/afficher-produit",name="afficher_produit")
     */
    public function afficherProduitAction(Request $request)
    {

      $entityManager = $this->getDoctrine()->getManager();
      $output='';

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
            

            $idcategorie=$request->request->get('categorie');
            $categorie=$entityManager->getRepository('BackBundle:Categories')->findById($idcategorie);
            $produits=$entityManager->getRepository('BackBundle:Produit')->findBy(array('categorie'=>$categorie));
            $number=count($produits);
            foreach ($produits as $produit) {
            	$output.='<option value='.$produit->getId().'>'.$produit->getTitre().'</option>';
            }
           

           $response=new JsonResponse(['output'=>$output,'success'=>true]);
             return $response;


    }else{
       

        $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    }


}




 /**
     * @Route("/user/home/gestion-offres",name="gestion_offres")
     */
    public function PageOffreAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
   {
     
       

      
 return $this->render('BackBundle:Fournisseur:offres.html.twig');

     }
   else{
     $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
     }



}















   /**
     * @Route("/afficher-offre",name="all_offre")
     */
    public function afficherOffreAction(Request $request)
    {

      $em = $this->getDoctrine()->getManager();
      $output='';

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {


     $offres=$em->getRepository('BackBundle:Offre')->findBy(array("user"=>$user),array('id' => 'desc'));
      $output=array('data'=>array());
    
      foreach ($offres as $offre) {
 $id =$offre->getId();         
$categorie=$offre->getCategorie()->getTitre();
$produit=$offre->getProduit()->getTitre();
$prix=$offre->getPrix();
$tiket=$offre->getTiket();
$qte=$offre->getQuantite();

     





$button=' <div  class="text-center">
                 
                    <a class="btn  btn-success btn-sm"  href="'.$this->get('router')->generate('modifier_offre', array('id' => $id)).'" ><i class="fa fa-pencil-square-o"></i> Modifier</a> 
                  <button class="btn  btn-danger btn-sm"  data-toggle="modal" data-target="#Modaloffredelete" onclick="deleteo('.$id.')" ><i class="fa fa-trash-o"></i> Supprimer</button></div>';



$output['data'][]=array(


 $categorie,
 $produit,
 $qte,
 $prix,
 $tiket,
 
 $button


    );




}

 $response=new JsonResponse($output);

/*$response = new \Symfony\Component\HttpFoundation\Response(json_encode($output));
$response->headers->set('Content-Type', 'application/json');
*/return $response;














     }

 }















    /**
     * @Route("/user/home/delete-offre/{id}",name="delete_offre")
     */
    public function deleteoffreAction(Request $request,$id)
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {
     
       if($request->isXmlHttpRequest())
       {
        $offre=$em->getRepository('BackBundle:Offre')->find($id);
  
    $em->remove($offre);
     $em->flush();
       $msg="Offre supprimer avec success !";
                $response=new JsonResponse(['success'=>true,'message'=>$msg]);

                return $response;

        }else{

              $msg="Erreur requete";
                $response=new JsonResponse(['success'=>false,'message'=>$msg]);

                return $response;

        }
      
       



     }  else{
     
      $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
       
    }



    }






   /**
     * @Route("/user/home/modifier-offre-{id}",name="modifier_offre")
     */
    public function modifierOffreAction(Request $request,$id)
    {

    	 $em = $this->getDoctrine()->getManager();
    	 $offre=$em->getRepository('BackBundle:Offre')->find($id);
 $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $anciennephoto=$offre->getImage();
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {



           $form=$this->createFormBuilder($offre)

         ->add('titre', TextType::class)
         ->add('description', TextareaType::class)
      








          

          ->add('prix', MoneyType::class)
           ->add('quantite', NumberType::class)

         // ->add('prix',TextType::class)
  

          
             ->add('tiket', NumberType::class)
          
               ->add('image', FileType::class, array('label' => 'Votre Image','data_class' => null))












->getForm();
$form->handleRequest($request);
if($form->isSubmitted() ){
if( $form->isValid()){

           if($form['image']->getData() != null)
       {
          $file =$form['image']->getData();

            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where brochures are stored
            $file->move(
                $this->getParameter('logo_directory'),
                $fileName
            );

         $offre->setImage($fileName);
     }else{

     $offre->setImage($anciennephoto);
 }



 $em->persist($offre);


      $em->flush();


//$userManager = $container->get('fos_user.user_manager');


       
      /*  if($request->isXmlHttpRequest())
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

      return $response;*/
      $this->get('session')->getFlashBag()->add('ModificationSuccess','Offre modifier Successfly !!');
       return $this->redirect( $this->generateUrl('gestion_offres'));



    }

   }



      
       return $this->render('BackBundle:Fournisseur:modifieroffre.html.twig',['form'=>$form->createView(),'id'=>$id]);  

    }else{
    	 $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));  
    }
}





































}   