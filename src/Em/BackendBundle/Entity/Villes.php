<?php

namespace Em\BackendBundle\Entity;

/**
 * Villes
 */
class Villes
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
    private $slug;

    /**
     * @var string
     */
    private $description;


    /**
     * @var \Em\BackendBundle\Entity\Pays
     */
    protected $pays;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Villes
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
     * Set description
     *
     * @param string $description
     *
     * @return Villes
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
     * Set urlmap
     *
     * @param string $urlmap
     *
     * @return Villes
     */
    public function setUrlmap($urlmap)
    {
        $this->urlmap = $urlmap;

        return $this;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Villes
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
     * Set pays
     *
     * @param \Em\BackendBundle\Entity\Pays $pays
     *
     * @return Villes
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
}
