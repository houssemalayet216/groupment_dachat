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

class ProduitsController extends Controller
{




   /**
     * @Route("/produit-{id}-detailles" ,name="produit_detailles")
     */
    public function detaillesProduitAction(Request $request,$id)
    {


      
      $em = $this->getDoctrine()->getManager();   
      $produit =$em->getRepository('BackBundle:Offre')->find($id);
      

           return $this->render('@Front/Content/detailsproduit.html.twig',['produit'=>$produit]);
    
    }


















    /**
     * @Route("/produit-{produit}" ,name="filter_par_produit")
     */
    public function filtrerParProduitAction(Request $request,$produit)
    {
       
             $em = $this->getDoctrine()->getManager();    
            $prod =$em->getRepository('BackBundle:Produit')->findOneBy(array('titre'=>$produit));
           
             $listeProduits =$em->getRepository('BackBundle:Offre')->findBy(array('produit'=>$prod),array('datePublication' => 'DESC'));
             $listeprods=$this->get('knp_paginator')->paginate(
        $listeProduits,
        
        $request->query->get('page', 1),9);
             
            return $this->render('FrontBundle:Content:listeproduits.html.twig',['listeprods'=>$listeprods,'prod'=>$prod]);   


    }


    /**
     * @Route("/{categorie}-produits" ,name="filtrer_par_categorie")
     */
    public function filtrerParCategorieAction(Request $request,$categorie)
    {
      $listeProduitsCat='';
      $listeprodsCatgories='';

      $em = $this->getDoctrine()->getManager();    
           
              if($categorie=='Nouveaux produits')
              {

             $listeProduitsCat=$em->getRepository('BackBundle:Offre')->findBy(array(),array('datePublication'=>'DESC'));

                $listeprodsCatgories=$this->get('knp_paginator')->paginate(
        $listeProduitsCat,
        
        $request->query->get('page', 1),9);




              }else{



              

            $cat =$em->getRepository('BackBundle:Categories')->findOneBy(array('titre'=>$categorie));
             $listeProduitsCat =$em->getRepository('BackBundle:Offre')->findBy(array('categorie'=>$cat),array('datePublication' => 'DESC'));
             $listeprodsCatgories=$this->get('knp_paginator')->paginate(
        $listeProduitsCat,
        
        $request->query->get('page', 1),9);

                   }
             
            return $this->render('FrontBundle:Content:listeproduits.html.twig',['listeprodsCatgories'=>$listeprodsCatgories,'listeProduitsCat'=>$listeProduitsCat]);



    }



  
  /**
     * @Route("/get-nombre-tiket" ,name="get_nbr_tiket_session")
     */
    public function getNbrTiketAction(Request $request)
    {
            $bool='';

         if($request->isXmlHttpRequest())
                     {

           $tikets=$request->request->get('nbrTiket');
            $totale=$request->request->get('total');
           
         $this->get('session')->set('totale',$totale);
         $this->get('session')->set('tikets',$tikets);
         
         $tiket=$this->get('session')->get('tikets');
          if($tiket!=null)
          {
            $bool=true;
          }else{
            $bool=false;
          }

        $response=new JsonResponse(array('success'=>$bool));
        return $response;

                     }


      
}
   




}