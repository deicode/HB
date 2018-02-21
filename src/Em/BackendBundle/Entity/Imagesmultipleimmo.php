<?php

namespace Em\BackendBundle\Entity;

/**
 * Imagesmultipleimmo
 */
class Imagesmultipleimmo
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
     * @var \Em\BackendBundle\Entity\Bienimmo
     */
    protected $bienimmo;


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
     * Set url
     *
     * @param string $url
     *
     * @return Imagesmultipleimmo
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
     * @return Imagesmultipleimmo
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
     * @return Imagesmultipleimmo
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
     * @return Imagesmultipleimmo
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
     * Set bienimmo
     *
     * @param \Em\BackendBundle\Entity\Bienimmo $bienimmo
     *
     * @return Imagesmultipleimmo
     */
    public function setBienimmo(\Em\BackendBundle\Entity\Bienimmo $bienimmo = null)
    {
        $this->bienimmo = $bienimmo;

        return $this;
    }

    /**
     * Get bienimmo
     *
     * @return \Em\BackendBundle\Entity\Bienimmo
     */
    public function getBienimmo()
    {
        return $this->bienimmo;
    }
}
