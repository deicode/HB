<?php

namespace Em\BackendBundle\Entity;

/**
 * Pub
 */
class Pub
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $titre;

    /**
     * @var \DateTime
     */
    private $dateadd;

    /**
     * @var \DateTime
     */
    private $datestart;

    /**
     * @var \DateTime
     */
    private $dateend;

    /**
     * @var int
     */
    private $pourcentage;

    /**
     * @var string
     */
    private $prixstart;

    /**
     * @var \Em\BackendBundle\Entity\Agences
     */
    protected $agences;


    /**
     * @var \Em\FrontendBundle\Entity\Images
     */
    protected $images;

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
     * @return Pub
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
     * Set hotel
     *
     * @param string $hotel
     *
     * @return Pub
     */
    public function setHotel($hotel)
    {
        $this->hotel = $hotel;

        return $this;
    }







    /**
     * Set prixstart
     *
     * @param string $prixstart
     *
     * @return Pub
     */
    public function setPrixstart($prixstart)
    {
        $this->prixstart = $prixstart;

        return $this;
    }

    /**
     * Get prixstart
     *
     * @return string
     */
    public function getPrixstart()
    {
        return $this->prixstart;
    }
    /**
     * @var \Em\FrontendBundle\Entity\Images
     */
    private $Images;


    /**
     * Set images
     *
     * @param \Em\FrontendBundle\Entity\Images $images
     *
     * @return Pub
     */
    public function setImages(\Em\FrontendBundle\Entity\Images $images = null)
    {
        $this->Images = $images;

        return $this;
    }

    /**
     * Get images
     *
     * @return \Em\FrontendBundle\Entity\Images
     */
    public function getImages()
    {
        return $this->Images;
    }

    /**
     * Set agences
     *
     * @param \Em\BackendBundle\Entity\Agences $agences
     *
     * @return Pub
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
     * Set dateadd
     *
     * @param \DateTime $dateadd
     *
     * @return Pub
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
     * Set datestart
     *
     * @param \DateTime $datestart
     *
     * @return Pub
     */
    public function setDatestart($datestart)
    {
        $this->datestart = $datestart;

        return $this;
    }

    /**
     * Get datestart
     *
     * @return \DateTime
     */
    public function getDatestart()
    {
        return $this->datestart;
    }

    /**
     * Set dateend
     *
     * @param \DateTime $dateend
     *
     * @return Pub
     */
    public function setDateend($dateend)
    {
        $this->dateend = $dateend;

        return $this;
    }

    /**
     * Get dateend
     *
     * @return \DateTime
     */
    public function getDateend()
    {
        return $this->dateend;
    }

    /**
     * Set pourcentage
     *
     * @param integer $pourcentage
     *
     * @return Pub
     */
    public function setPourcentage($pourcentage)
    {
        $this->pourcentage = $pourcentage;

        return $this;
    }

    /**
     * Get pourcentage
     *
     * @return integer
     */
    public function getPourcentage()
    {
        return $this->pourcentage;
    }
}
