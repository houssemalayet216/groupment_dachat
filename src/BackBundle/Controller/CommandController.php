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

class CommandController extends Controller
{






 /**
     * @Route("/user/home/commandes-client",name="liste_commande_client")
     */
    public function PageCommandeClientAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
   {
     
       

      
 return $this->render('BackBundle:Client:commande.html.twig');

     }
   else{
     $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
     }



}















   /**
     * @Route("/afficher-commande-client",name="all_commande_client")
     */
    public function afficherCommandeClientAction(Request $request)
    {

      $em = $this->getDoctrine()->getManager();
      $output='';

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_CLIENT')))
    {


     $commandes=$em->getRepository('BackBundle:Commande')->findBy(array("user"=>$user),array('dateCommandation' => 'desc'));
      $output=array('data'=>array());
    
      foreach ($commandes as $commande) {
 $id =$commande->getId();         
$pu=$commande->getPrix();
$produit=$commande->getOffre()->getProduit()->getTitre();
$tiket=$commande->getOffre()->getTiket();
$nbrtiket=$commande->getNbrtiket();
$totale=$commande->getTotale();
$status='';

if($commande->getStatus()=='Annuler')
{
$status='<span class="label label-danger">'.$commande->getStatus().'</span>';
}
if($commande->getStatus()=='En attente')
{
$status='<span class="label label-success">'.$commande->getStatus().'</span>';
}

if($commande->getStatus()=='En cour de livraison')
{
$status='<span class="label label-info">'.$commande->getStatus().'</span>';
}

if($commande->getStatus()=='Livré')
{
$status='<span class="label label-success">'.$commande->getStatus().'</span>';
}

if($commande->getStatus()=='Payer')
{
$status='<span class="label label-info">'.$commande->getStatus().'</span>';
}


     





$button=' <div  class="text-center">
                 
                  
                  <button class="btn  btn-info btn-sm"  data-toggle="modal" data-target="#VoirDetailleCommandeClient" onclick="VoirDetailleCommandeClient('.$id.')" ><i class="fa fa-eye"></i> Voir</button></div>';



$output['data'][]=array(


 
 $produit,
  $pu,
 $tiket,
 $nbrtiket,
 $totale,
 $status,
 
 $button


    );




}

 $response=new JsonResponse($output);

/*$response = new \Symfony\Component\HttpFoundation\Response(json_encode($output));
$response->headers->set('Content-Type', 'application/json');
*/
return $response;





     }

 }









 /**
     * @Route("/user/home/commandes-fournisseur",name="liste_commande_fournisseur")
     */
    public function PageCommandeFournisseurAction(Request $request)
    {

     $user = $this->container->get('security.token_storage')->getToken()->getUser();
      $entityManager = $this->getDoctrine()->getManager();

     $authchecker= $this->container->get('security.authorization_checker');
     if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
   {
     
       

      
 return $this->render('BackBundle:Fournisseur:commande.html.twig');

     }
   else{
     $this->get('session')->getFlashBag()->add('noticeErreur','Vous devez  connecté !!');
         return $this->redirect( $this->generateUrl('fos_user_security_login'));
    
     }



}















   /**
     * @Route("/afficher-commande-fournisseur",name="all_commande_fournisseur")
     */
    public function afficherCommandeFournisseurAction(Request $request)
    {

      $em = $this->getDoctrine()->getManager();
      $output='';

    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    
   
    $authchecker= $this->container->get('security.authorization_checker');
    if((is_object($user) || $user instanceof UserInterface) &&  ($authchecker->isGranted('ROLE_FOURNISSEUR')))
    {


     $commandes=$em->getRepository('BackBundle:Commande')->findBy(array("fournisseur"=>$user),array('dateCommandation' => 'desc'));
      $output=array('data'=>array());
    
      foreach ($commandes as $commande) {
 $id =$commande->getId();
 $email =$commande->getUser()->getEmail();         
$pu=$commande->getPrix();
$tiket=$commande->getOffre()->getTiket();
$nbrtiket=$commande->getNbrtiket();
$dateCommandation=$commande->getDateCommandation()->format('Y-m-d');
$totale=$commande->getTotale();
$status='';

if($commande->getStatus()=='Annuler')
{
$status='<span class="label label-danger">'.$commande->getStatus().'</span>';
}
if($commande->getStatus()=='En attente')
{
$status='<span class="label label-success">'.$commande->getStatus().'</span>';
}

if($commande->getStatus()=='En cours de livraison')
{
$status='<span class="label label-info">'.$commande->getStatus().'</span>';
}

if($commande->getStatus()=='Livré')
{
$status='<span class="label label-success">'.$commande->getStatus().'</span>';
}

if($commande->getStatus()=='Payer')
{
$status='<span class="label label-info">'.$commande->getStatus().'</span>';
}


     





$button=' <div  class="text-center">
                 
                  
                  <button class="btn  btn-info btn-sm"  data-toggle="modal" data-target="#VoirDetailleCommandeClient" onclick="VoirDetailleCommandeClient('.$id.')" ><i class="fa fa-eye"></i> Voir</button></div>';



$output['data'][]=array(


 
 $email,
  $pu,
 $tiket,
 $nbrtiket,
 $totale,
 $dateCommandation,
 $status,
 $button


    );




}

 $response=new JsonResponse($output);

/*$response = new \Symfony\Component\HttpFoundation\Response(json_encode($output));
$response->headers->set('Content-Type', 'application/json');
*/
return $response;





     }

 }












































































}