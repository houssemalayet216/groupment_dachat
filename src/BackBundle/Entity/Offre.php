<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Offre
 *
 * @ORM\Table(name="offre")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\OffreRepository")
 * Symfony\Component\Validator\Constraints as Assert;
 */
class Offre
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     *@Assert\NotBlank(message="le champ titre  ne doit pas etre vide")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;

    /**
     * @var int
     *
     * @ORM\Column(name="quantite", type="integer")
     * 
     *@Assert\Regex(pattern="/^[0-9]+$/",
      *message="la quantite doit etre un nombre valide." )
     *
     */
    private $quantite;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     * 
     *@Assert\Regex(
     *     pattern="/^[0-9]{1,}(\.|)[0-9]{0,2}$/",
     *     message="Le prix est pas valide."
     * )
     *
     *
     */
    private $prix;

    /**
     * @var int
     *
     * @ORM\Column(name="tiket", type="integer")
     * 
     *@Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     message="Le champ tiket doit etre un nombre"
     * )
     * 
     */
    private $tiket;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text" , nullable=true)
     * 
     *  @Assert\File(mimeTypes={ "image/jpeg","image/png" },mimeTypesMessage = "Le fichier doit etre image" )
     */
    private $image;


      /** 
   * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Produit") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $produit;


   /** 
   * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Categories") 
   * @ORM\JoinColumn(nullable=true)
   */
   private $categorie;


    /** 
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User") 
   * @ORM\JoinColumn(nullable=false)
   */
   private $user;

  /**
     * @var int
     *
     * @ORM\Column(name="disponible", type="integer",nullable=false)
     */
   private $disponible;

     /**
     * @var \DateTime
     *
     * @ORM\Column(name="datepublication", type="datetime")
     */
    private $datePublication;

   


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return Offre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Offre
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set quantite
     *
     * @param integer $quantite
     *
     * @return Offre
     */
    public function setQuantite($quantite)
    {
        $this->quantite = $quantite;

        return $this;
    }

    /**
     * Get quantite
     *
     * @return int
     */
    public function getQuantite()
    {
        return $this->quantite;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Offre
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set tiket
     *
     * @param integer $tiket
     *
     * @return Offre
     */
    public function setTiket($tiket)
    {
        $this->tiket = $tiket;

        return $this;
    }

    /**
     * Get tiket
     *
     * @return int
     */
    public function getTiket()
    {
        return $this->tiket;
    }

    /**
     * Set image
     *
     * @param string $image
     *
     * @return Offre
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set produit
     *
     * @param \BackBundle\Entity\Produit $produit
     *
     * @return Offre
     */
    public function setProduit(\BackBundle\Entity\Produit $produit = null)
    {
        $this->produit = $produit;

        return $this;
    }

    /**
     * Get produit
     *
     * @return \BackBundle\Entity\Produit
     */
    public function getProduit()
    {
        return $this->produit;
    }

    /**
     * Set categorie
     *
     * @param \BackBundle\Entity\Categories $categorie
     *
     * @return Offre
     */
    public function setCategorie(\BackBundle\Entity\Categories $categorie = null)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \BackBundle\Entity\Categories
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

   

    /**
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Offre
     */
    public function setUser(\AppBundle\Entity\User $user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set disponible
     *
     * @param integer $disponible
     *
     * @return Offre
     */
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;

        return $this;
    }

    /**
     * Get disponible
     *
     * @return integer
     */
    public function getDisponible()
    {
        return $this->disponible;
    }

    /**
     * Set datePublication
     *
     * @param \DateTime $datePublication
     *
     * @return Offre
     */
    public function setDatePublication($datePublication)
    {
        $this->datePublication = $datePublication;

        return $this;
    }

    /**
     * Get datePublication
     *
     * @return \DateTime
     */
    public function getDatePublication()
    {
        return $this->datePublication;
    }
}
