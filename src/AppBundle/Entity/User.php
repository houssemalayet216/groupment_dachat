<?php
        // src/AppBundle/Entity/User.php

        namespace AppBundle\Entity;

        use FOS\UserBundle\Model\User as BaseUser;
        use Doctrine\ORM\Mapping as ORM;
        use Symfony\Component\Validator\Constraints as Assert;

        /**
         * @ORM\Entity
         * @ORM\Table(name="user")
         */
        class User extends BaseUser
        {
            /**
             * @ORM\Id
             * @ORM\Column(type="integer")
             * @ORM\GeneratedValue(strategy="AUTO")
             */
            protected $id;

             /**
     * @var string
     *
     * @ORM\Column(name="civilite", type="string", length=255,nullable=true)
     * 
     */
    protected $civilite;


      /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255,nullable=true)
     *
     */
    protected $nom;


   





    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255,nullable=true)
     * 
     */
    protected $prenom;

     /**
     * @var string
     *
     * @ORM\Column(name="ville", type="string", length=255,nullable=true)
     * @Assert\NotBlank(message="le champ ville  ne doit pas etre vide")
     */
    protected $ville;


    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255,nullable=true)
     * @Assert\NotBlank(message="le champ adresse  ne doit pas etre vide")
     */
    protected $adresse;

    

      /**
     * @var string
     *
     * @ORM\Column(name="fonction", type="string", length=255,nullable=true)
     * 
     */
    protected $fonction;


      /**
     * @var string
     *
     * @ORM\Column(name="responsable", type="string", length=255,nullable=true)
     * 
     */
    protected $responsable;


     /**
     * @var string
     *
     * @ORM\Column(name="cp", type="integer", length=4,nullable=true)
     * @Assert\NotBlank(message="le champ code postale  ne doit pas etre vide")
     *   *@Assert\Regex(
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
     *
     */
    protected $cp;




     /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="integer", length=8,nullable=true)
     * @Assert\NotBlank(message="le champ telephone  ne doit pas etre vide")
     *   *@Assert\Regex(
     *     pattern="/^(9|2|5|4|7)[0-9]{7}$/",
     *     message="Némuro telephone est pas valid."
     * )
     * 
     */
    protected $telephone;


    /**
     * @var string
     *
     * @ORM\Column(name="logo", type="text",nullable=true)
     * @Assert\File(mimeTypes={ "image/jpeg","image/png" },mimeTypesMessage = "Le fichier doit etre image" )
     */
    protected $logo;

     /**
     * @var string
     *
     * @ORM\Column(name="photo", type="text",nullable=true)
     * @Assert\File(mimeTypes={ "image/jpeg","image/png" },mimeTypesMessage = "Le fichier doit etre image" )
     */
    protected $photo;

            public function __construct()
            {
                parent::__construct();
                // your own logic
            }
        
    /**
     * Set civilite
     *
     * @param string $civilite
     *
     * @return User
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return User
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
     * @return User
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
     * Set ville
     *
     * @param string $ville
     *
     * @return User
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
     * @return User
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
     * Set fonction
     *
     * @param string $fonction
     *
     * @return User
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set responsable
     *
     * @param string $responsable
     *
     * @return User
     */
    public function setResponsable($responsable)
    {
        $this->responsable = $responsable;

        return $this;
    }

    /**
     * Get responsable
     *
     * @return string
     */
    public function getResponsable()
    {
        return $this->responsable;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     *
     * @return User
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set telephone
     *
     * @param integer $telephone
     *
     * @return User
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return integer
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set logo
     *
     * @param string $logo
     *
     * @return User
     */
    public function setLogo($logo)
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * Get logo
     *
     * @return string
     */
    public function getLogo()
    {
        return $this->logo;
    }

    /**
     * Set photo
     *
     * @param string $photo
     *
     * @return User
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;

        return $this;
    }

    /**
     * Get photo
     *
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }
}
