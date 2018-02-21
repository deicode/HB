<?php

namespace Em\BackendBundle\Entity;

/**
 * News
 */
class News
{
    /**
     * @var int
     */
    private $id;

    /*
     * On itilise l entite
     */
    public function __construct(\Em\BackendBundle\Entity\News $data = null){

        if(!empty($data)){
            $this->title       = $data->getTitle();
            $this->description = $data->getDescription();
            $this->dateedit    = $data->getDateedit();
            $this->dateajout   = $data->getDateajout();
            $this->keywords    = $data->getKeywords();
            $this->contenus    = $data->getContenus();
            $this->titre       = $data->getTitre();
            $this->slug        = $data->getSlug();
            $this->publish     = $data->getPublish();
            $this->resume      = $data->getResume();


        }

    }

    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected  $description;

    /**
     * @var string
     */
    protected  $keywords;

    /**
     * @var \DateTime
     */
    protected  $dateajout;

    /**
     * @var \DateTime
     */
    protected  $dateedit;

    /**
     * @var string
     */
    protected  $titre;

    /**
     *
     * @var string
     */
    protected $slug;

    /**
     * @var boolean
     */
    protected $publish;

    /**
     * @var string
     */
    protected $resume;

    /**
     * @var string
     */
    protected $contenus;

    /**
     * @var \Em\FrontendBundle\Entity\Images
     */
    protected $Images;



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
     * Set title
     *
     * @param string $title
     *
     * @return News
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
     * Set description
     *
     * @param string $description
     *
     * @return News
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
     * Set keywords
     *
     * @param string $keywords
     *
     * @return News
     */
    public function setKeywords($keywords)
    {
        $this->keywords = $keywords;

        return $this;
    }

    /**
     * Get keywords
     *
     * @return string
     */
    public function getKeywords()
    {
        return $this->keywords;
    }

    /**
     * Set dateajout
     *
     * @param \DateTime $dateajout
     *
     * @return News
     */
    public function setDateajout($dateajout)
    {
        $this->dateajout = $dateajout;

        return $this;
    }

    /**
     * Get dateajout
     *
     * @return \DateTime
     */
    public function getDateajout()
    {
        return $this->dateajout;
    }

    /**
     * Set dateedit
     *
     * @param \DateTime $dateedit
     *
     * @return News
     */
    public function setDateedit($dateedit)
    {
        $this->dateedit = $dateedit;

        return $this;
    }

    /**
     * Get dateedit
     *
     * @return \DateTime
     */
    public function getDateedit()
    {
        return $this->dateedit;
    }

    /**
     * Set titre
     *
     * @param string $titre
     *
     * @return News
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
     * Set slug
     *
     * @param string $slug
     *
     * @return News
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
     * Set resume
     *
     * @param string $resume
     *
     * @return News
     */
    public function setResume($resume)
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * Get resume
     *
     * @return string
     */
    public function getResume()
    {
        return $this->resume;
    }

    /**
     * Set contenus
     *
     * @param string $contenus
     *
     * @return News
     */
    public function setContenus($contenus)
    {
        $this->contenus = $contenus;

        return $this;
    }

    /**
     * Get contenus
     *
     * @return string
     */
    public function getContenus()
    {
        return $this->contenus;
    }

    /**
     * Set publish
     *
     * @param boolean $publish
     *
     * @return News
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
     * @return News
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
