<?php

namespace FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
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
use BackBundle\Entity\Commande;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use PDO;

class DefaultController extends Controller
{
















   
     /**
     * @Route("/" , name="frontpage")
     */
    public function indexAction(Request $request)
    {
       
      $prod=array();
       $produits=$this->get('session')->get('produits');
       if(empty($produits)){
        $this->get('session')->set('produits', $prod);
       }

           $em=$this->getDoctrine()->getManager();
           
           




     

       $user = $this->container->get('security.token_storage')->getToken()->getUser();
          
    if (is_object($user) || $user instanceof UserInterface) {
        
      return $this->redirectToRoute('redirect_user');
        
     }

        

        return $this->render('@Front/Content/content.html.twig');
    }






    /**
     * @Route("/user/home" ,name="redirect_user")
     */
    public function redirectionAction(Request $request)
    {
         $user = $this->container->get('security.token_storage')->getToken()->getUser();
    	$authchecker= $this->container->get('security.authorization_checker');
    	
         



    if((is_object($user) || $user instanceof UserInterface))
    {
    

     return $this->render('@Front/Content/content.html.twig');
     

   

    }

 return $this->render('@Front/Content/content.html.twig');


}




    /**
     * @Route("/user/home/espace" , name="espacepage")
     */
    public function homeAction(Request $request)
    {
       $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $authchecker= $this->container->get('security.authorization_checker');

        $em=$this->getDoctrine()->getManager();
   


    if((is_object($user) || $user instanceof UserInterface) &&($authchecker->isGranted('ROLE_CLIENT')))
        {


           return $this->render('BackBundle:Client:content.html.twig');   
        }
        
         elseif((is_object($user) || $user instanceof UserInterface)&&($authchecker->isGranted('ROLE_FOURNISSEUR')))
        {

           




           return $this->render('BackBundle:Fournisseur:content.html.twig');   
        }else{

            $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));  

        }

    }



     /**
     * @Route("/insertsession" ,name="insertinsession")
     */
    public function insertInSessionAction(Request $request)
    {

        if($request->isXmlHttpRequest())
                     {

                       
        

        $id=$request->request->get('id_product');


        $em=$this->getDoctrine()->getManager();
        $produit=$em->getRepository('BackBundle:Offre')->find($id);
         $produits=array();
         $produits=$this->get('session')->get('produits');
         if( !empty($produits) )
         {
            
            
           array_push($produits,$produit);
            $this->get('session')->set('produits', $produits);  

         }else{
           
          
           array_push($produits,$produit);
           $this->get('session')->set('produits', $produits);

         }


          
                        $response=new JsonResponse(array('success'=>true));
                         return $response;

                     }


}





     /**
     * @Route("/getcounter" ,name="getcounterpanier")
     */
    public function getCounterAction(Request $request)
    {

        if($request->isXmlHttpRequest())
                     {

                       
        

      
     
         $produits=$this->get('session')->get('produits');
         $counter=count($produits);
       
 

          
                        $response=new JsonResponse(array('success'=>true,'counter'=>$counter,'produits'=>$produits));
                         return $response;

                     }


}











     /**
     * @Route("/cart" ,name="user_cart")
     */
    public function userCartAction(Request $request)
    {
         $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $authchecker= $this->container->get('security.authorization_checker');
        
        $produits=$this->get('session')->get('produits');

        


     return $this->render('@Front/Client/cart.html.twig',['produits'=>$produits]);
     


}


     /**
     * @Route("/commander" ,name="user_commander")
     */
    public function userCommanderAction(Request $request,$id)
    {
         $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $authchecker= $this->container->get('security.authorization_checker');
        
         



    
    

     return $this->render('@Front/Client/commander.html.twig');
     

   



 


}



     /**
     * @Route("/savetiket" ,name="enregistrer_nbr_tiket")
     */
    public function enregistrerTiketAction(Request $request)
    {
        
        
         
     if($request->isXmlHttpRequest())
                     {

           $tikets=$request->request->get('nbrTiket');
            $totale=$request->request->get('total');
            $prix=$request->request->get('prix');
         $this->get('session')->set('totale',$totale);
         $this->get('session')->set('tikets',$tikets);
         $this->get('session')->set('prix',$prix);

        $response=new JsonResponse(array('success'=>true));
        return $response;

                     }



}





   /**
     * @Route("/user/home/validercommande-{id}",name="valider_commander")
     */
    public function validerCommandeAction(Request $request,$id)
    {

         $em = $this->getDoctrine()->getManager();
       
 $user = $this->container->get('security.token_storage')->getToken()->getUser();
 $offre=$em->getRepository('BackBundle:Offre')->find($id);
 $produt=$offre->getProduit()->getTitre();
 $tik=$offre->getTiket();
$prix=$offre->getPrix();
$nbrtiket= $this->get('session')->get('tikets');
$total= $this->get('session')->get('totale');
  
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {

           $commande=new Commande();

           $form=$this->createFormBuilder($commande)

         ->add('nom', TextType::class)
         ->add('prenom', TextType::class)
         ->add('email', EmailType::class)
         ->add('telephone', TelType::class)
         ->add('adresse', TextType::class)
         ->add('adress', TextType::class)
         ->add('cp', TextType::class)
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
      





->getForm();
$form->handleRequest($request);
if($form->isSubmitted() ){
if( $form->isValid()){

$fournisseur=$offre->getUser();    
$commande->setUser($user);
$commande->setOffre($offre);
$commande->setPrix($prix);
$commande->setTotale($total);
$commande->setNbrtiket($nbrtiket);
 $commande->setDateCommandation(new \DateTime());
 $commande->setStatus('En attente');
 $commande->setFournisseur($fournisseur);


 $em->persist($commande);


      $em->flush();





      $this->get('session')->set('totale','');
         $this->get('session')->set('tikets','');
      

         

      $this->get('session')->getFlashBag()->add('ValidCommande','Commande envoyé avec success !!');
       return $this->redirect( $this->generateUrl('user_cart')); 



    } 






   }



      
       return $this->render('FrontBundle:Client:Commander.html.twig',['form'=>$form->createView(),'prix'=>$prix,'nbrtikets'=>$nbrtiket,'totale'=>$total,'id'=>$id,'produit'=>$produt,'tik'=>$tik]);



    }else{
         $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));  
    }
}






































}
