<?php

namespace Em\BackendBundle\Entity;

/**
 * Informationsite
 */
class Informationsite
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $urlmap;

    /**
     * @var string
     */
    private $telephone;

    /**
     * @var string
     */
    private $mobile;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $adresse;

    /**
     * @var string
     */
    private $urlfacebook;

    /**
     * @var string
     */
    private $description;

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
     * Set urlmap
     *
     * @param string $urlmap
     *
     * @return Informationsite
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
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Informationsite
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
     * Set mobile
     *
     * @param string $mobile
     *
     * @return Informationsite
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;

        return $this;
    }

    /**
     * Get mobile
     *
     * @return string
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * Set adresse
     *
     * @param string $adresse
     *
     * @return Informationsite
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
     * Set urlfacebook
     *
     * @param string $urlfacebook
     *
     * @return Informationsite
     */
    public function setUrlfacebook($urlfacebook)
    {
        $this->urlfacebook = $urlfacebook;

        return $this;
    }

    /**
     * Get urlfacebook
     *
     * @return string
     */
    public function getUrlfacebook()
    {
        return $this->urlfacebook;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Informationsite
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
     * Set description
     *
     * @param string $description
     *
     * @return Informationsite
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
}
