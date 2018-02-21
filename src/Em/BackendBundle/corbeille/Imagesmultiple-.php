<?php

namespace Em\BackendBundle\Entity;

/**
 * Imagesmultiple
 */
class Imagesmultiple
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $alt;

    /**
     * @var \DateTime
     */
    private $dateadd;

    /**
     * @var \Em\BackendBundle\Entity\Agences
     */
    protected $agence;


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
     * Set url
     *
     * @param string $url
     *
     * @return Imagesmultiple
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Imagesmultiple
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
     * Set alt
     *
     * @param string $alt
     *
     * @return Imagesmultiple
     */
    public function setAlt($alt)
    {
        $this->alt = $alt;

        return $this;
    }

    /**
     * Get alt
     *
     * @return string
     */
    public function getAlt()
    {
        return $this->alt;
    }

    /**
     * Set dateadd
     *
     * @param \DateTime $dateadd
     *
     * @return Imagesmultiple
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
     * Set agence
     *
     * @param \Em\BackendBundle\Entity\Agences $agence
     *
     * @return Imagesmultiple
     */
    public function setAgence(\Em\BackendBundle\Entity\Agences $agence = null)
    {
        $this->agence = $agence;

        return $this;
    }

    /**
     * Get agence
     *
     * @return \Em\BackendBundle\Entity\Agences
     */
    public function getAgence()
    {
        return $this->agence;
    }


}
