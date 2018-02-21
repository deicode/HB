<?php

namespace Em\FrontendBundle\Entity;

/**
 * Commande
 */
class Commande
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $montant;

    /**
     * @var string
     */
    private $transid;

    /**
     * @var string
     */
    private $methode;

    /**
     * @var string
     */
    private $transstatus;

    /**
     * @var string
     */
    private $signature;

    /**
     * @var string
     */
    private $statut;

    /**
     * @var string
     */
    private $errormessage;

    /**
     * @var string
     */
    private $datecreation;

    /**
     * @var string
     */
    private $datemodification;

    /**
     * @var string
     */
    private $datepaiement;



    /**
     * @var \Em\FrontendBundle\Entity\Reservations
     */
    protected $reservations;

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
     * Set montant
     *
     * @param integer $montant
     *
     * @return Commande
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return int
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set transid
     *
     * @param string $transid
     *
     * @return Commande
     */
    public function setTransid($transid)
    {
        $this->transid = $transid;

        return $this;
    }

    /**
     * Get transid
     *
     * @return string
     */
    public function getTransid()
    {
        return $this->transid;
    }

    /**
     * Set methode
     *
     * @param string $methode
     *
     * @return Commande
     */
    public function setMethode($methode)
    {
        $this->methode = $methode;

        return $this;
    }

    /**
     * Get methode
     *
     * @return string
     */
    public function getMethode()
    {
        return $this->methode;
    }

    /**
     * Set transstatus
     *
     * @param string $transstatus
     *
     * @return Commande
     */
    public function setTransstatus($transstatus)
    {
        $this->transstatus = $transstatus;

        return $this;
    }

    /**
     * Get transstatus
     *
     * @return string
     */
    public function getTransstatus()
    {
        return $this->transstatus;
    }

    /**
     * Set signature
     *
     * @param string $signature
     *
     * @return Commande
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature
     *
     * @return string
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * Set statut
     *
     * @param string $statut
     *
     * @return Commande
     */
    public function setStatut($statut)
    {
        $this->statut = $statut;

        return $this;
    }

    /**
     * Get statut
     *
     * @return string
     */
    public function getStatut()
    {
        return $this->statut;
    }

    /**
     * Set errormessage
     *
     * @param string $errormessage
     *
     * @return Commande
     */
    public function setErrormessage($errormessage)
    {
        $this->errormessage = $errormessage;

        return $this;
    }

    /**
     * Get errormessage
     *
     * @return string
     */
    public function getErrormessage()
    {
        return $this->errormessage;
    }


    /**
     * Set reservations
     *
     * @param \Em\FrontendBundle\Entity\Reservations $reservations
     *
     * @return Commande
     */
    public function setReservations(\Em\FrontendBundle\Entity\Reservations $reservations = null)
    {
        $this->reservations = $reservations;

        return $this;
    }

    /**
     * Get reservations
     *
     * @return \Em\FrontendBundle\Entity\Reservations
     */
    public function getReservations()
    {
        return $this->reservations;
    }

    /**
     * Set datecreation
     *
     * @param string $datecreation
     *
     * @return Commande
     */
    public function setDatecreation($datecreation)
    {
        $this->datecreation = $datecreation;

        return $this;
    }

    /**
     * Get datecreation
     *
     * @return string
     */
    public function getDatecreation()
    {
        return $this->datecreation;
    }

    /**
     * Set datemodification
     *
     * @param string $datemodification
     *
     * @return Commande
     */
    public function setDatemodification($datemodification)
    {
        $this->datemodification = $datemodification;

        return $this;
    }

    /**
     * Get datemodification
     *
     * @return string
     */
    public function getDatemodification()
    {
        return $this->datemodification;
    }

    /**
     * Set datepaiement
     *
     * @param string $datepaiement
     *
     * @return Commande
     */
    public function setDatepaiement($datepaiement)
    {
        $this->datepaiement = $datepaiement;

        return $this;
    }

    /**
     * Get datepaiement
     *
     * @return string
     */
    public function getDatepaiement()
    {
        return $this->datepaiement;
    }
}
