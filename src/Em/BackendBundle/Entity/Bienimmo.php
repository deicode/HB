<?php

namespace Em\BackendBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Bienimmo
 */
class Bienimmo
{
    /**
     * @var int
     */
    private $id;


    /**
     * @Assert\NotNull()
     *  @var string
     */
    private $adresse;

    /**
     * @Assert\NotNull()
     *  @var string
     */
    private $libelle;

    /**
     *
     * @var int
     */
    protected $prix;

    //**
    // * @Assert\Length(
    // *      min = 8,
    // *      max = 60,
    // *      minMessage = "Caracteres minimale {{ limit }} ",
    // *      maxMessage = "Caractere maxiamle {{ limit }} "
    // * )
    // */
    /**
     * @var \Em\BackendBundle\Entity\User
     */
    protected $nomprenoms;

    /**
     * @Assert\Length(
     *      min = 8,
     *      max = 15,
     *      minMessage = "Caracteres minimale {{ limit }} ",
     *      maxMessage = "Caractere maxiamle {{ limit }} "
     * )
     */
    protected $telephone;
    /**
     * @var bool
     */
    protected $recommander;


    /**
     * @Assert\Type("string")
     */
    private $description;

    /**
     * @var string
     */
    private $etage;

    /**
     * @var string
     */
    private $anneeconstruction;

    /**
     * @var string
     */
    private $surfacehabitable;

    /**
     * @var string
     */
    private $surfaceterrain;

    /**
     * @Assert\Type("int")
     */
    private $nbrepiece;

    /**
     * @var string
     */
    private $etatbien;

    /**
     * @var bool
     */
    private $jardin;

    /**
     * @var bool
     */
    private $piscine;

    /**
     * @var bool
     */
    private $balcon;

    /**
     * @var bool
     */
    private $terrasse;

    /**
     * @var bool
     */
    private $parking;

    /**
     * @var bool
     */
    private $garage;

    /**
     * @var bool
     */
    private $cave;

    /**
     * @var bool
     */
    private $ascenseur;


    /**
     * @var string
     */
    protected $reference;

    /**
     * @var string
     */
    protected $urlmap;

    /**
     * @var \Em\BackendBundle\Entity\Pays
     */
    protected $pays;

    /**
     * @var string
     */
    protected $villes;

    /**
     * @var \Em\BackendBundle\Entity\Statusimmo
     */
    protected $statusimmo;


    /**
     * @var \Em\BackendBundle\Entity\Typeimmo
     */
    protected $typeimmo;

    /**
     * @var \Em\BackendBundle\Entity\Etatimmo
     */
    protected $etatimmo;



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
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Bienimmo
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
     * Set etage
     *
     * @param string $etage
     *
     * @return Bienimmo
     */
    public function setEtage($etage)
    {
        $this->etage = $etage;

        return $this;
    }

    /**
     * Get etage
     *
     * @return string
     */
    public function getEtage()
    {
        return $this->etage;
    }

    /**
     * Set anneeconstruction
     *
     * @param string $anneeconstruction
     *
     * @return Bienimmo
     */
    public function setAnneeconstruction($anneeconstruction)
    {
        $this->anneeconstruction = $anneeconstruction;

        return $this;
    }

    /**
     * Get anneeconstruction
     *
     * @return string
     */
    public function getAnneeconstruction()
    {
        return $this->anneeconstruction;
    }

    /**
     * Set surfacehabitable
     *
     * @param string $surfacehabitable
     *
     * @return Bienimmo
     */
    public function setSurfacehabitable($surfacehabitable)
    {
        $this->surfacehabitable = $surfacehabitable;

        return $this;
    }

    /**
     * Get surfacehabitable
     *
     * @return string
     */
    public function getSurfacehabitable()
    {
        return $this->surfacehabitable;
    }

    /**
     * Set surfaceterrain
     *
     * @param string $surfaceterrain
     *
     * @return Bienimmo
     */
    public function setSurfaceterrain($surfaceterrain)
    {
        $this->surfaceterrain = $surfaceterrain;

        return $this;
    }

    /**
     * Get surfaceterrain
     *
     * @return string
     */
    public function getSurfaceterrain()
    {
        return $this->surfaceterrain;
    }

    /**
     * Set nbrepiece
     *
     * @param string $nbrepiece
     *
     * @return Bienimmo
     */
    public function setNbrepiece($nbrepiece)
    {
        $this->nbrepiece = $nbrepiece;

        return $this;
    }

    /**
     * Get nbrepiece
     *
     * @return string
     */
    public function getNbrepiece()
    {
        return $this->nbrepiece;
    }

    /**
     * Set etatbien
     *
     * @param string $etatbien
     *
     * @return Bienimmo
     */
    public function setEtatbien($etatbien)
    {
        $this->etatbien = $etatbien;

        return $this;
    }

    /**
     * Get etatbien
     *
     * @return string
     */
    public function getEtatbien()
    {
        return $this->etatbien;
    }

    /**
     * Set jardin
     *
     * @param boolean $jardin
     *
     * @return Bienimmo
     */
    public function setJardin($jardin)
    {
        $this->jardin = $jardin;

        return $this;
    }

    /**
     * Get jardin
     *
     * @return bool
     */
    public function getJardin()
    {
        return $this->jardin;
    }

    /**
     * Set piscine
     *
     * @param boolean $piscine
     *
     * @return Bienimmo
     */
    public function setPiscine($piscine)
    {
        $this->piscine = $piscine;

        return $this;
    }

    /**
     * Get piscine
     *
     * @return bool
     */
    public function getPiscine()
    {
        return $this->piscine;
    }

    /**
     * Set balcon
     *
     * @param boolean $balcon
     *
     * @return Bienimmo
     */
    public function setBalcon($balcon)
    {
        $this->balcon = $balcon;

        return $this;
    }

    /**
     * Get balcon
     *
     * @return bool
     */
    public function getBalcon()
    {
        return $this->balcon;
    }

    /**
     * Set terrasse
     *
     * @param boolean $terrasse
     *
     * @return Bienimmo
     */
    public function setTerrasse($terrasse)
    {
        $this->terrasse = $terrasse;

        return $this;
    }

    /**
     * Get terrasse
     *
     * @return bool
     */
    public function getTerrasse()
    {
        return $this->terrasse;
    }

    /**
     * Set parking
     *
     * @param boolean $parking
     *
     * @return Bienimmo
     */
    public function setParking($parking)
    {
        $this->parking = $parking;

        return $this;
    }

    /**
     * Get parking
     *
     * @return bool
     */
    public function getParking()
    {
        return $this->parking;
    }

    /**
     * Set garage
     *
     * @param boolean $garage
     *
     * @return Bienimmo
     */
    public function setGarage($garage)
    {
        $this->garage = $garage;

        return $this;
    }

    /**
     * Get garage
     *
     * @return bool
     */
    public function getGarage()
    {
        return $this->garage;
    }

    /**
     * Set cave
     *
     * @param boolean $cave
     *
     * @return Bienimmo
     */
    public function setCave($cave)
    {
        $this->cave = $cave;

        return $this;
    }

    /**
     * Get cave
     *
     * @return bool
     */
    public function getCave()
    {
        return $this->cave;
    }

    /**
     * Set ascenseur
     *
     * @param boolean $ascenseur
     *
     * @return Bienimmo
     */
    public function setAscenseur($ascenseur)
    {
        $this->ascenseur = $ascenseur;

        return $this;
    }

    /**
     * Get ascenseur
     *
     * @return bool
     */
    public function getAscenseur()
    {
        return $this->ascenseur;
    }
    /**
     * @var \DateTime
     */
    private $dateadd;

    /**
     * @var boolean
     */
    private $locked;


    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     *
     * @return Bienimmo
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
     * Set urlmap
     *
     * @param string $urlmap
     *
     * @return Bienimmo
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
     * Set locked
     *
     * @param boolean $locked
     *
     * @return Bienimmo
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
     * Set pays
     *
     * @param \Em\BackendBundle\Entity\Pays $pays
     *
     * @return Bienimmo
     */
    public function setPays(\Em\BackendBundle\Entity\Pays $pays = null)
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Get pays
     *
     * @return \Em\BackendBundle\Entity\Pays
     */
    public function getPays()
    {
        return $this->pays;
    }


    /**
     * Set statusimmo
     *
     * @param \Em\BackendBundle\Entity\Statusimmo $statusimmo
     *
     * @return Bienimmo
     */
    public function setStatusimmo(\Em\BackendBundle\Entity\Statusimmo $statusimmo = null)
    {
        $this->statusimmo = $statusimmo;

        return $this;
    }

    /**
     * Get statusimmo
     *
     * @return \Em\BackendBundle\Entity\Statusimmo
     */
    public function getStatusimmo()
    {
        return $this->statusimmo;
    }

    /**
     * Set typeimmo
     *
     * @param \Em\BackendBundle\Entity\Typeimmo $typeimmo
     *
     * @return Bienimmo
     */
    public function setTypeimmo(\Em\BackendBundle\Entity\Typeimmo $typeimmo = null)
    {
        $this->typeimmo = $typeimmo;

        return $this;
    }

    /**
     * Get typeimmo
     *
     * @return \Em\BackendBundle\Entity\Typeimmo
     */
    public function getTypeimmo()
    {
        return $this->typeimmo;
    }

    /**
     * Set etatimmo
     *
     * @param \Em\BackendBundle\Entity\Etatimmo $etatimmo
     *
     * @return Bienimmo
     */
    public function setEtatimmo(\Em\BackendBundle\Entity\Etatimmo $etatimmo = null)
    {
        $this->etatimmo = $etatimmo;

        return $this;
    }

    /**
     * Get etatimmo
     *
     * @return \Em\BackendBundle\Entity\Etatimmo
     */
    public function getEtatimmo()
    {
        return $this->etatimmo;
    }

    /**
     * Set reference
     *
     * @param string $reference
     *
     * @return Bienimmo
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }



    /**
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Bienimmo
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    /**
     * Get libelle
     *
     * @return string
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Bienimmo
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
     * Set prix
     *
     * @param integer $prix
     *
     * @return Bienimmo
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return integer
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set recommander
     *
     * @param boolean $recommander
     *
     * @return Bienimmo
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

    /**
     * Set nomprenoms
     *
     * @param \Em\BackendBundle\Entity\User $nomprenoms
     *
     * @return Bienimmo
     */
    public function setNomprenoms(\Em\BackendBundle\Entity\User $nomprenoms = null)
    {
        $this->nomprenoms = $nomprenoms;

        return $this;
    }

    /**
     * Get nomprenoms
     *
     * @return \Em\BackendBundle\Entity\User
     */
    public function getNomprenoms()
    {
        return $this->nomprenoms;
    }
    

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Bienimmo
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
     * @var string
     */
    private $ville;


    /**
     * Set ville
     *
     * @param string $ville
     *
     * @return Bienimmo
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
     * @var \Em\BackendBundle\Entity\Typesaison
     */
    private $typesaision;


    /**
     * Set typesaision
     *
     * @param \Em\BackendBundle\Entity\Typesaison $typesaision
     *
     * @return Bienimmo
     */
    public function setTypesaision(\Em\BackendBundle\Entity\Typesaison $typesaision = null)
    {
        $this->typesaision = $typesaision;

        return $this;
    }

    /**
     * Get typesaision
     *
     * @return \Em\BackendBundle\Entity\Typesaison
     */
    public function getTypesaision()
    {
        return $this->typesaision;
    }
    /**
     * @var \Em\BackendBundle\Entity\Typesaison
     */
    private $typesaison;


    /**
     * Set typesaison
     *
     * @param \Em\BackendBundle\Entity\Typesaison $typesaison
     *
     * @return Bienimmo
     */
    public function setTypesaison(\Em\BackendBundle\Entity\Typesaison $typesaison = null)
    {
        $this->typesaison = $typesaison;

        return $this;
    }

    /**
     * Get typesaison
     *
     * @return \Em\BackendBundle\Entity\Typesaison
     */
    public function getTypesaison()
    {
        return $this->typesaison;
    }
}
