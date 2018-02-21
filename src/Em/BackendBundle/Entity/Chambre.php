<?php

namespace Em\BackendBundle\Entity;

/**
 * Chambre
 */
class Chambre
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $typelit;

    /**
     * @var string
     */
    private $typchambre;

    /**
     * @var int
     */
    private $capacitemax;

    /**
     * @var \DateTime
     */
    private $dateadd;

    /**
     * @var int
     */
    private $totalchambre;

    /**
     * @var  string
     */
    private $prixinit;

    /**
     * @var int
     */
    private $prixchambre;

    /**
     * @var int
     */
    private $pourcentagesolde;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $slugchambre;

    /**
     * @var \Em\BackendBundle\Entity\Agences
     */
    protected $agences;


    /**
     * @var boolean
     */
    private  $climatisation ;

    /**
     * @var boolean
     */
     private  $douche ;

    /**
     * @var boolean
     */
private  $tvlcplasma ;


    /**
     * @var boolean
     */
private  $baignoire ;
    /**
     * @var boolean
     */
private  $cuisine ;
    /**
     * @var boolean
     */
private  $salon ;
    /**
     * @var boolean
     */
private  $refrigerateur ;
    /**
     * @var boolean
     */
private  $bureau ;
    /**
     * @var boolean
     */
private  $filmalademande ;
    /**
     * @var boolean
     */
private  $telephone ;
    /**
     * @var boolean
     */
private  $tv;
    /**
     * @var boolean
     */
private  $locked ;
    /**
     * @var boolean
     */
private  $minibar ;

    /**
     * @var \Em\FrontendBundle\Entity\Images
     */
    private $images;



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
     * Set typelit
     *
     * @param string $typelit
     *
     * @return Chambre
     */
    public function setTypelit($typelit)
    {
        $this->typelit = $typelit;

        return $this;
    }

    /**
     * Get typelit
     *
     * @return string
     */
    public function getTypelit()
    {
        return $this->typelit;
    }



    /**
     * Set capacitemax
     *
     * @param integer $capacitemax
     *
     * @return Chambre
     */
    public function setCapacitemax($capacitemax)
    {
        $this->capacitemax = $capacitemax;

        return $this;
    }

    /**
     * Get capacitemax
     *
     * @return int
     */
    public function getCapacitemax()
    {
        return $this->capacitemax;
    }

    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     *
     * @return Chambre
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
     * Set totalchambre
     *
     * @param integer $totalchambre
     *
     * @return Chambre
     */
    public function setTotalchambre($totalchambre)
    {
        $this->totalchambre = $totalchambre;

        return $this;
    }

    /**
     * Get totalchambre
     *
     * @return int
     */
    public function getTotalchambre()
    {
        return $this->totalchambre;
    }

    /**
     * Set prixinit
     *
     * @param integer $prixinit
     *
     * @return Chambre
     */
    public function setPrixinit($prixinit)
    {
        $this->prixinit = $prixinit;

        return $this;
    }

    /**
     * Get prixinit
     *
     * @return int
     */
    public function getPrixinit()
    {
        return $this->prixinit;
    }

    /**
     * Set prixchambre
     *
     * @param integer $prixchambre
     *
     * @return Chambre
     */
    public function setPrixchambre($prixchambre)
    {
        $this->prixchambre = $prixchambre;

        return $this;
    }

    /**
     * Get prixchambre
     *
     * @return int
     */
    public function getPrixchambre()
    {
        return $this->prixchambre;
    }

    /**
     * Set pourcentagesolde
     *
     * @param integer $pourcentagesolde
     *
     * @return Chambre
     */
    public function setPourcentagesolde($pourcentagesolde)
    {
        $this->pourcentagesolde = $pourcentagesolde;

        return $this;
    }

    /**
     * Get pourcentagesolde
     *
     * @return int
     */
    public function getPourcentagesolde()
    {
        return $this->pourcentagesolde;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Chambre
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
     * Set agences
     *
     * @param \Em\BackendBundle\Entity\Agences $agences
     *
     * @return Chambre
     */
    public function setAgences(\Em\BackendBundle\Entity\Agences $agences = null)
    {
        $this->agences = $agences;

        return $this;
    }

    /**
     * Get agences
     *
     * @return \Em\BackendBundle\Entity\Agences
     */
    public function getAgences()
    {
        return $this->agences;
    }

    /**
     * Set climatisation
     *
     * @param boolean $climatisation
     *
     * @return Chambre
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
     * Set douche
     *
     * @param boolean $douche
     *
     * @return Chambre
     */
    public function setDouche($douche)
    {
        $this->douche = $douche;

        return $this;
    }

    /**
     * Get douche
     *
     * @return boolean
     */
    public function getDouche()
    {
        return $this->douche;
    }

    /**
     * Set tvlcplasma
     *
     * @param boolean $tvlcplasma
     *
     * @return Chambre
     */
    public function setTvlcplasma($tvlcplasma)
    {
        $this->tvlcplasma = $tvlcplasma;

        return $this;
    }

    /**
     * Get tvlcplasma
     *
     * @return boolean
     */
    public function getTvlcplasma()
    {
        return $this->tvlcplasma;
    }

    /**
     * Set baignoire
     *
     * @param boolean $baignoire
     *
     * @return Chambre
     */
    public function setBaignoire($baignoire)
    {
        $this->baignoire = $baignoire;

        return $this;
    }

    /**
     * Get baignoire
     *
     * @return boolean
     */
    public function getBaignoire()
    {
        return $this->baignoire;
    }

    /**
     * Set cuisine
     *
     * @param boolean $cuisine
     *
     * @return Chambre
     */
    public function setCuisine($cuisine)
    {
        $this->cuisine = $cuisine;

        return $this;
    }

    /**
     * Get cuisine
     *
     * @return boolean
     */
    public function getCuisine()
    {
        return $this->cuisine;
    }

    /**
     * Set salon
     *
     * @param boolean $salon
     *
     * @return Chambre
     */
    public function setSalon($salon)
    {
        $this->salon = $salon;

        return $this;
    }

    /**
     * Get salon
     *
     * @return boolean
     */
    public function getSalon()
    {
        return $this->salon;
    }

    /**
     * Set refrigerateur
     *
     * @param boolean $refrigerateur
     *
     * @return Chambre
     */
    public function setRefrigerateur($refrigerateur)
    {
        $this->refrigerateur = $refrigerateur;

        return $this;
    }

    /**
     * Get refrigerateur
     *
     * @return boolean
     */
    public function getRefrigerateur()
    {
        return $this->refrigerateur;
    }

    /**
     * Set bureau
     *
     * @param boolean $bureau
     *
     * @return Chambre
     */
    public function setBureau($bureau)
    {
        $this->bureau = $bureau;

        return $this;
    }

    /**
     * Get bureau
     *
     * @return boolean
     */
    public function getBureau()
    {
        return $this->bureau;
    }

    /**
     * Set filmalademande
     *
     * @param boolean $filmalademande
     *
     * @return Chambre
     */
    public function setFilmalademande($filmalademande)
    {
        $this->filmalademande = $filmalademande;

        return $this;
    }

    /**
     * Get filmalademande
     *
     * @return boolean
     */
    public function getFilmalademande()
    {
        return $this->filmalademande;
    }

    /**
     * Set telephone
     *
     * @param boolean $telephone
     *
     * @return Chambre
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return boolean
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set tv
     *
     * @param boolean $tv
     *
     * @return Chambre
     */
    public function setTv($tv)
    {
        $this->tv = $tv;

        return $this;
    }

    /**
     * Get tv
     *
     * @return boolean
     */
    public function getTv()
    {
        return $this->tv;
    }

    /**
     * Set minibar
     *
     * @param boolean $minibar
     *
     * @return Chambre
     */
    public function setMinibar($minibar)
    {
        $this->minibar = $minibar;

        return $this;
    }

    /**
     * Get minibar
     *
     * @return boolean
     */
    public function getMinibar()
    {
        return $this->minibar;
    }

    /**
     * Set locked
     *
     * @param boolean $locked
     *
     * @return Chambre
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
     * @var string
     */
    private $typechambre;


    /**
     * Set typechambre
     *
     * @param string $typechambre
     *
     * @return Chambre
     */
    public function setTypechambre($typechambre)
    {
        $this->typechambre = $typechambre;

        return $this;
    }

    /**
     * Get typechambre
     *
     * @return string
     */
    public function getTypechambre()
    {
        return $this->typechambre;
    }

    /**
     * Set slugchambre
     *
     * @param string $slugchambre
     *
     * @return Chambre
     */
    public function setSlugchambre($slugchambre)
    {
        $this->slugchambre = $slugchambre;

        return $this;
    }

    /**
     * Get slugchambre
     *
     * @return string
     */
    public function getSlugchambre()
    {
        return $this->slugchambre;
    }

    /**
     * Set images
     *
     * @param \Em\FrontendBundle\Entity\Images $images
     *
     * @return Chambre
     */
    public function setImages(\Em\FrontendBundle\Entity\Images $images = null)
    {
        $this->images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return \Em\FrontendBundle\Entity\Images
     */
    public function getImages()
    {
        return $this->images;
    }
}
