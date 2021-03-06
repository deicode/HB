<?php

namespace Em\BackendBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Agences
 */
class Agences
{
    public function __construct()
    {
       $this->communes = null;
    }
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $prixinit;

    /**
     * @var string
     */
    private $pays;

    /**
     * @var string
     */
    private $grade;

    /**
     * @var string
     */
    private $status;

    /**
     * @var string
     */
    private $caracteristique;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @var string
     */
    private $urlmap;


    /**
     * @var \Datetime
     */
    private $dateadd;
    /**
     * @var string
     */
    private $adresse;

    /**
     * @var boolean
     */
    private $locked;

    /**
     * @var boolean
     */
    private $wifi;

    /**
     * @var boolean
     */
    private $piscine;

    /**
     * @var boolean
     */
    private $climatisation;


    /**
     * @var boolean
     */
    private $restaurant;

    /**
     * @var boolean
     */
    private $servicechambre;


    /**
     * @var boolean
     */
   private $petitdejeuner ;

    /**
     * @var boolean
     */
    private $nightclub ;

    /**
     * @var boolean
     */
    private $massage ;


    /**
     * @var boolean
     */
    private $gym;

     /**
     * @var boolean
     */
   private $casino;

    /**
     * @var string
     */
    protected $ville;

    /**
     * @var int
     */
     protected $pourcentagecommercial;


    /**
     * @var \Em\BackendBundle\Entity\User
     */
    protected $proprietaire;

    /**
     * @var boolean
     */
    private $recommander;


    /**
     * Get id
     *
     * @return integer
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
     * @return Agences
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
     * Set title
     *
     * @param string $title
     *
     * @return Agences
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     *
     * @return Agences
     */
    public function setDateadd($dateadd)
    {
        $this->dateadd = $dateadd;

        return $this;
    }

    /**
     * Get dateadd
     *
     * @return \DateTime
     */
    public function getDateadd()
    {
        return $this->dateadd;
    }

    /**
     * Set grade
     *
     * @param string $grade
     *
     * @return Agences
     */
    public function setGrade($grade)
    {
        $this->grade = $grade;

        return $this;
    }

    /**
     * Get grade
     *
     * @return string
     */
    public function getGrade()
    {
        return $this->grade;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Agences
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
     * Set caracteristique
     *
     * @param string $caracteristique
     *
     * @return Agences
     */
    public function setCaracteristique($caracteristique)
    {
        $this->caracteristique = $caracteristique;

        return $this;
    }

    /**
     * Get caracteristique
     *
     * @return string
     */
    public function getCaracteristique()
    {
        return $this->caracteristique;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Agences
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
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Agences
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
     * Set urlmap
     *
     * @param string $urlmap
     *
     * @return Agences
     */
    public function setUrlmap($urlmap)
    {
        $this->urlmap = $urlmap;

        return $this;
    }

    /**
     * Get urlmap
     *
     * @return string
     */
    public function getUrlmap()
    {
        return $this->urlmap;
    }

    /**
     * Set wifi
     *
     * @param boolean $wifi
     *
     * @return Agences
     */
    public function setWifi($wifi)
    {
        $this->wifi = $wifi;

        return $this;
    }

    /**
     * Get wifi
     *
     * @return boolean
     */
    public function getWifi()
    {
        return $this->wifi;
    }

    /**
     * Set piscine
     *
     * @param boolean $piscine
     *
     * @return Agences
     */
    public function setPiscine($piscine)
    {
        $this->piscine = $piscine;

        return $this;
    }

    /**
     * Get piscine
     *
     * @return boolean
     */
    public function getPiscine()
    {
        return $this->piscine;
    }

    /**
     * Set climatisation
     *
     * @param boolean $climatisation
     *
     * @return Agences
     */
    public function setClimatisation($climatisation)
    {
        $this->climatisation = $climatisation;

        return $this;
    }

    /**
     * Get climatisation
     *
     * @return boolean
     */
    public function getClimatisation()
    {
        return $this->climatisation;
    }

    /**
     * Set restaurant
     *
     * @param boolean $restaurant
     *
     * @return Agences
     */
    public function setRestaurant($restaurant)
    {
        $this->restaurant = $restaurant;

        return $this;
    }

    /**
     * Get restaurant
     *
     * @return boolean
     */
    public function getRestaurant()
    {
        return $this->restaurant;
    }

    /**
     * Set servicechambre
     *
     * @param boolean $servicechambre
     *
     * @return Agences
     */
    public function setServicechambre($servicechambre)
    {
        $this->servicechambre = $servicechambre;

        return $this;
    }

    /**
     * Get servicechambre
     *
     * @return boolean
     */
    public function getServicechambre()
    {
        return $this->servicechambre;
    }

    /**
     * Set petitdejeuner
     *
     * @param boolean $petitdejeuner
     *
     * @return Agences
     */
    public function setPetitdejeuner($petitdejeuner)
    {
        $this->petitdejeuner = $petitdejeuner;

        return $this;
    }

    /**
     * Get petitdejeuner
     *
     * @return boolean
     */
    public function getPetitdejeuner()
    {
        return $this->petitdejeuner;
    }

    /**
     * Set nightclub
     *
     * @param boolean $nightclub
     *
     * @return Agences
     */
    public function setNightclub($nightclub)
    {
        $this->nightclub = $nightclub;

        return $this;
    }

    /**
     * Get nightclub
     *
     * @return boolean
     */
    public function getNightclub()
    {
        return $this->nightclub;
    }

    /**
     * Set massage
     *
     * @param boolean $massage
     *
     * @return Agences
     */
    public function setMassage($massage)
    {
        $this->massage = $massage;

        return $this;
    }

    /**
     * Get massage
     *
     * @return boolean
     */
    public function getMassage()
    {
        return $this->massage;
    }

    /**
     * Set gym
     *
     * @param boolean $gym
     *
     * @return Agences
     */
    public function setGym($gym)
    {
        $this->gym = $gym;

        return $this;
    }

    /**
     * Get gym
     *
     * @return boolean
     */
    public function getGym()
    {
        return $this->gym;
    }

    /**
     * Set casino
     *
     * @param boolean $casino
     *
     * @return Agences
     */
    public function setCasino($casino)
    {
        $this->casino = $casino;

        return $this;
    }

    /**
     * Get casino
     *
     * @return boolean
     */
    public function getCasino()
    {
        return $this->casino;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Agences
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
     * Set locked
     *
     * @param boolean $locked
     *
     * @return Agences
     */
    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }

    /**
     * Get locked
     *
     * @return boolean
     */
    public function getLocked()
    {
        return $this->locked;
    }



    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Agences
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
     * Set proprietaire
     *
     * @param \Em\BackendBundle\Entity\User $proprietaire
     *
     * @return Agences
     */
    public function setProprietaire(\Em\BackendBundle\Entity\User $proprietaire = null)
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    /**
     * Get proprietaire
     *
     * @return \Em\BackendBundle\Entity\User
     */
    public function getProprietaire()
    {
        return $this->proprietaire;
    }

    /**
     * Set prixinit
     *
     * @param integer $prixinit
     *
     * @return Agences
     */
    public function setPrixinit($prixinit)
    {
        $this->prixinit = $prixinit;

        return $this;
    }

    /**
     * Get prixinit
     *
     * @return integer
     */
    public function getPrixinit()
    {
        return $this->prixinit;
    }

    /**
     * Set pays
     *
     * @param string $pays
     *
     * @return Agences
     */
    public function setPays($pays)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * Set pourcentagecommercial
     *
     * @param integer $pourcentagecommercial
     *
     * @return Agences
     */
    public function setPourcentagecommercial($pourcentagecommercial)
    {
        $this->pourcentagecommercial = $pourcentagecommercial;

        return $this;
    }

    /**
     * Get pourcentagecommercial
     *
     * @return integer
     */
    public function getPourcentagecommercial()
    {
        return $this->pourcentagecommercial;
    }

    /**
     * Set recommander
     *
     * @param boolean $recommander
     *
     * @return Agences
     */
    public function setRecommander($recommander)
    {
        $this->recommander = $recommander;

        return $this;
    }

    /**
     * Get recommander
     *
     * @return boolean
     */
    public function getRecommander()
    {
        return $this->recommander;
    }
}
