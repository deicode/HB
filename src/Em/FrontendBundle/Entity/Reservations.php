<?php

namespace Em\FrontendBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * Reservations
 */
class Reservations
{
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
    private $prenoms;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $modepayement;

    /**
     * @var int
     */
    private $prixtotal;

    /**
     * @var string
     */
    private $datearrivee;

    /**
     * @var string
     */
    private $datedepart;

    /**
     * @var string
     */
    private $typeaction;

    /**
     * @var int
     */
    private $nbadulte;

    /**
     * @var int
     */
    private $nbenfant;

    /**
     * @var int
     */
    private $nbjour;

    /**
     * @var int
     */
    private $nbchambre;

    /**
     * @var \Em\BackendBundle\Entity\Chambre
     */
    protected $chambre;


    /**
     * @var \DateTime
     */
    private $dateadd;

    /**
     * @var string
     */
    private $numeroreservation;

    /**
     * @var string
     */
    private $status;

    /**
     * @var boolean
     */
    private $confirmer;

    /**
     * @Assert\Length(
     *      min = 8,
     *      max = 15,
     *      minMessage = "votre numéro doit être au minimum {{ limit }} caractères",
     *      maxMessage = "votre numéro doit être au maximum {{ limit }} caractères"
     * )
     * @var string
     */
    protected  $phone;


    /**
     * @var \Em\BackendBundle\Entity\User
     */
    protected $proprietaire;



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
     * @return Reservations
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
     * Set prenoms
     *
     * @param string $prenoms
     *
     * @return Reservations
     */
    public function setPrenoms($prenoms)
    {
        $this->prenoms = $prenoms;

        return $this;
    }

    /**
     * Get prenoms
     *
     * @return string
     */
    public function getPrenoms()
    {
        return $this->prenoms;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Reservations
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Reservations
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
     * Set modepayement
     *
     * @param string $modepayement
     *
     * @return Reservations
     */
    public function setModepayement($modepayement)
    {
        $this->modepayement = $modepayement;

        return $this;
    }

    /**
     * Get modepayement
     *
     * @return string
     */
    public function getModepayement()
    {
        return $this->modepayement;
    }

    /**
     * Set prixtotal
     *
     * @param integer $prixtotal
     *
     * @return Reservations
     */
    public function setPrixtotal($prixtotal)
    {
        $this->prixtotal = $prixtotal;

        return $this;
    }

    /**
     * Get prixtotal
     *
     * @return integer
     */
    public function getPrixtotal()
    {
        return $this->prixtotal;
    }

    /**
     * Set typeaction
     *
     * @param string $typeaction
     *
     * @return Reservations
     */
    public function setTypeaction($typeaction)
    {
        $this->typeaction = $typeaction;

        return $this;
    }

    /**
     * Get typeaction
     *
     * @return string
     */
    public function getTypeaction()
    {
        return $this->typeaction;
    }

    /**
     * Set datearrivee
     *
     * @param string $datearrivee
     *
     * @return Reservations
     */
    public function setDatearrivee($datearrivee)
    {
        $this->datearrivee = $datearrivee;

        return $this;
    }

    /**
     * Get datearrivee
     *
     * @return string
     */
    public function getDatearrivee()
    {
        return $this->datearrivee;
    }

    /**
     * Set datedepart
     *
     * @param string $datedepart
     *
     * @return Reservations
     */
    public function setDatedepart($datedepart)
    {
        $this->datedepart = $datedepart;

        return $this;
    }

    /**
     * Get datedepart
     *
     * @return string
     */
    public function getDatedepart()
    {
        return $this->datedepart;
    }

    /**
     * Set nbadulte
     *
     * @param integer $nbadulte
     *
     * @return Reservations
     */
    public function setNbadulte($nbadulte)
    {
        $this->nbadulte = $nbadulte;

        return $this;
    }

    /**
     * Get nbadulte
     *
     * @return integer
     */
    public function getNbadulte()
    {
        return $this->nbadulte;
    }

    /**
     * Set nbenfant
     *
     * @param integer $nbenfant
     *
     * @return Reservations
     */
    public function setNbenfant($nbenfant)
    {
        $this->nbenfant = $nbenfant;

        return $this;
    }

    /**
     * Get nbenfant
     *
     * @return integer
     */
    public function getNbenfant()
    {
        return $this->nbenfant;
    }

    /**
     * Set nbchambre
     *
     * @param integer $nbchambre
     *
     * @return Reservations
     */
    public function setNbchambre($nbchambre)
    {
        $this->nbchambre = $nbchambre;

        return $this;
    }

    /**
     * Get nbchambre
     *
     * @return integer
     */
    public function getNbchambre()
    {
        return $this->nbchambre;
    }

    /**
     * Set nbjour
     *
     * @param integer $nbjour
     *
     * @return Reservations
     */
    public function setNbjour($nbjour)
    {
        $this->nbjour = $nbjour;

        return $this;
    }

    /**
     * Get nbjour
     *
     * @return integer
     */
    public function getNbjour()
    {
        return $this->nbjour;
    }

    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     *
     * @return Reservations
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
     * Set numeroreservation
     *
     * @param string $numeroreservation
     *
     * @return Reservations
     */
    public function setNumeroreservation($numeroreservation)
    {
        $this->numeroreservation = $numeroreservation;

        return $this;
    }

    /**
     * Get numeroreservation
     *
     * @return string
     */
    public function getNumeroreservation()
    {
        return $this->numeroreservation;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Reservations
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
     * Set confirmer
     *
     * @param boolean $confirmer
     *
     * @return Reservations
     */
    public function setConfirmer($confirmer)
    {
        $this->confirmer = $confirmer;

        return $this;
    }

    /**
     * Get confirmer
     *
     * @return boolean
     */
    public function getConfirmer()
    {
        return $this->confirmer;
    }

    /**
     * Set chambre
     *
     * @param \Em\BackendBundle\Entity\Chambre $chambre
     *
     * @return Reservations
     */
    public function setChambre(\Em\BackendBundle\Entity\Chambre $chambre = null)
    {
        $this->chambre = $chambre;

        return $this;
    }

    /**
     * Get chambre
     *
     * @return \Em\BackendBundle\Entity\Chambre
     */
    public function getChambre()
    {
        return $this->chambre;
    }

    /**
     * Set proprietaire
     *
     * @param \Em\BackendBundle\Entity\User $proprietaire
     *
     * @return Reservations
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
}
