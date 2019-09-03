<?php


namespace FrontBundle\Twig\Extension;
use Doctrine\ORM\EntityManagerInterface ;


class MenuExtension extends  \Twig_Extension
{
    protected $entityManager;
  

    public function __construct(EntityManagerInterface  $entityManager)
    {
        $this->entityManager = $entityManager;
    
    }

    public function getMenu()
    {
      
           


           
          $fruits =$this->entityManager->getRepository('BackBundle:Categories')->find(1);
          $leguimes = $this->entityManager->getRepository('BackBundle:Categories')->find(2);
           
        
           



          $fruitProduit=$this->entityManager->getRepository('BackBundle:Produit')->findBy(array('categorie'=>$fruits));
          $leguimeProduit=$this->entityManager->getRepository('BackBundle:Produit')->findBy(array('categorie'=>$leguimes));
         

         
          $listefruits=$this->entityManager->getRepository('BackBundle:Offre')->findBy(array('categorie'=>$fruits),array('datePublication'=>'DESC'),6);

          $listeleguimes=$this->entityManager->getRepository('BackBundle:Offre')->findBy(array('categorie'=>$leguimes),array('datePublication'=>'DESC'),6);


            $nouveaux=$this->entityManager->getRepository('BackBundle:Offre')->findBy(array(),array('datePublication'=>'DESC'),6);





        return array (
           'fruits'=>$fruitProduit,'leguimes'=> $leguimeProduit,'listefruits'=>$listefruits,'listeleguimes'=>$listeleguimes,'nouveaux'=>$nouveaux
        );
    }




   /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('menu', array($this,'getMenu')),
        );
    }






    public function getName()
    {
        return "FrontBundle:MenuExtension";
    }
}