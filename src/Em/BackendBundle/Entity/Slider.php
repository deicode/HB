<?php

namespace Em\BackendBundle\Entity;

/**
 * Slider
 */
class Slider
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $prix;

    /**
     * @var string
     */
    protected $enbaled;

    /**
     * @var \Em\FrontendBundle\Entity\Images
     */
    protected $images;

    /**
     * @var \Em\BackendBundle\Entity\Statusimmo
     */
    protected $statusimmo;

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
     * Set title
     *
     * @param string $title
     *
     * @return Slider
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
     * Set prix
     *
     * @param string $prix
     *
     * @return Slider
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return string
     */
    public function getPrix()
    {
        return $this->prix;
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
     * @return Slider
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
     * @var boolean
     */
    private $enabled;


    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Slider
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return boolean
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set statusimmo
     *
     * @param \Em\BackendBundle\Entity\Statusimmo $statusimmo
     *
     * @return Slider
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
}
