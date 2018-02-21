<?php

namespace Em\BackendBundle\Entity;

/**
 * Communes
 */
class Communes
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
     * @var \Em\BackendBundle\Entity\Villes
     */
    private $Villes;

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
     * @return Communes
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
     * @return Communes
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
     * Set villes
     *
     * @param \Em\BackendBundle\Entity\Villes $villes
     *
     * @return Communes
     */
    public function setVilles(\Em\BackendBundle\Entity\Villes $villes = null)
    {
        $this->Villes = $villes;

        return $this;
    }

    /**
     * Get villes
     *
     * @return \Em\BackendBundle\Entity\Villes
     */
    public function getVilles()
    {
        return $this->Villes;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return Communes
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
     * @var string
     */
    private $urlmap;


    /**
     * Set urlmap
     *
     * @param string $urlmap
     *
     * @return Communes
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
}
