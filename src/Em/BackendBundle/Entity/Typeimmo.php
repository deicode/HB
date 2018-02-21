<?php

namespace Em\BackendBundle\Entity;

/**
 * Typeimmo
 */
class Typeimmo
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $libelle;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var string
     */
    private $description;

    /**
     * @var bool
     */
    private $publish;

    /**
     * @var \Em\FrontendBundle\Entity\Images
     */
    protected $Images;

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
     * Set libelle
     *
     * @param string $libelle
     *
     * @return Typeimmo
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
     * Set slug
     *
     * @param string $slug
     *
     * @return Typeimmo
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Typeimmo
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
     * Set publish
     *
     * @param boolean $publish
     *
     * @return Typeimmo
     */
    public function setPublish($publish)
    {
        $this->publish = $publish;

        return $this;
    }

    /**
     * Get publish
     *
     * @return boolean
     */
    public function getPublish()
    {
        return $this->publish;
    }

    /**
     * Set images
     *
     * @param \Em\FrontendBundle\Entity\Images $images
     *
     * @return Typeimmo
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
}
