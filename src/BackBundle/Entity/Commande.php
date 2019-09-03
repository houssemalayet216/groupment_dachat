<?php

namespace BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="BackBundle\Repository\CommandeRepository")
 */
class Commande
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
     * @ORM\Column(name="nom", type="string", length=255)
     * @Assert\NotBlank(message="le champ nom  ne doit pas etre vide")
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     * @Assert\NotBlank(message="le champ prenom ne doit pas etre vide")
     */
    private $prenom;

    /**
     * @var string
     *
     *
     * @ORM\Column(name="email", type="string", length=255)
     * @Assert\NotBlank(message="le champ email ne doit pas etre vide")
     * @Assert\Email(
     *     message = " email est pas valid.",
     *     checkMX = true
     * )
    
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=255)
     * @Assert\NotBlank(message=" le champs Ville ne doit pas etre vide")
     *@Assert\Regex(
     *     pattern="/^[0-9]{8}$/",
     *     message=" Némuro n'est valid "
     * )
     *
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255)
     * @Assert\NotBlank(message=" le champs Ville ne doit pas etre vide")
     */
    private $ville;

    /**
     * @var string
     * 
     * @ORM\Column(name="adresse", type="string", length=255)
     * @Assert\NotBlank(message=" le champs adresse 1 ne doit pas etre vide")
     */
    private $adresse;

    /**
     * @var string
     * 
     * @ORM\Column(name="adress", type="string", length=255)
     * @Assert\NotBlank(message="adresse 2 ne doit pas etre vide")
     */
    private $adress;


     /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255)
     */
    private $status;





    /**
     * @var int
     *
     * @ORM\Column(name="nbrtiket", type="integer")
     *
     */
    private $nbrtiket;

    /**
     * @var int
     *
     * @ORM\Column(name="cp", type="integer")
     * @Assert\NotBlank(message="code postale ne doit pas etre vide")
     *@Assert\Regex(
     *     pattern="/^[0-9]+$/",
     *     message="code postale doit etre un nombre"
     * )
     * @Assert\Length(
     *     min=4,
     *     max=4,
     *     minMessage="Code postale doit etre en 4 chiffre",
     *     maxMessage="Code postale doit etre en 4 chiffre"
     * )
     *
     */
    private $cp;

    /**
     * @var float
     *
     * @ORM\Column(name="totale", type="float")
     */
    private $totale;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     *
     */
    private $prix;

     /** 
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User") 
   * @ORM\JoinColumn(nullable=false)
   */
   private $user;

  

   /** 
   * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User") 
   * @ORM\JoinColumn(nullable=false)
   */
   private $fournisseur;







    /** 
   * @ORM\ManyToOne(targetEntity="BackBundle\Entity\Offre") 
   * @ORM\JoinColumn(nullable=false)
   */
   private $offre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datecommandation", type="datetime")
     */
    private $dateCommandation;




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
     * Set nom
     *
     * @param string $nom
     *
     * @return Commande
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Commande
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Commande
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Commande
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Commande
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Commande
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;

        return $this;
    }

    /**
     * Get adresse
     *
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Commande
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set nbrtiket
     *
     * @param integer $nbrtiket
     *
     * @return Commande
     */
    public function setNbrtiket($nbrtiket)
    {
        $this->nbrtiket = $nbrtiket;

        return $this;
    }

    /**
     * Get nbrtiket
     *
     * @return int
     */
    public function getNbrtiket()
    {
        return $this->nbrtiket;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     *
     * @return Commande
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return int
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set totale
     *
     * @param float $totale
     *
     * @return Commande
     */
    public function setTotale($totale)
    {
        $this->totale = $totale;

        return $this;
    }

    /**
     * Get totale
     *
     * @return float
     */
    public function getTotale()
    {
        return $this->totale;
    }

    /**
     * Set prix
     *
     * @param float $prix
     *
     * @return Commande
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
     * Set user
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Commande
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
     * Set offre
     *
     * @param \BackBundle\Entity\Offre $offre
     *
     * @return Commande
     */
    public function setOffre(\BackBundle\Entity\Offre $offre)
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Get offre
     *
     * @return \BackBundle\Entity\Offre
     */
    public function getOffre()
    {
        return $this->offre;
    }

    /**
     * Set dateCommandation
     *
     * @param \DateTime $dateCommandation
     *
     * @return Commande
     */
    public function setDateCommandation($dateCommandation)
    {
        $this->dateCommandation = $dateCommandation;

        return $this;
    }

    /**
     * Get dateCommandation
     *
     * @return \DateTime
     */
    public function getDateCommandation()
    {
        return $this->dateCommandation;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Commande
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set fournisseur
     *
     * @param \AppBundle\Entity\User $fournisseur
     *
     * @return Commande
     */
    public function setFournisseur(\AppBundle\Entity\User $fournisseur)
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    /**
     * Get fournisseur
     *
     * @return \AppBundle\Entity\User
     */
    public function getFournisseur()
    {
        return $this->fournisseur;
    }
}
