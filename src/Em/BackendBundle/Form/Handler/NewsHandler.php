<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;

use Em\BackendBundle\Entity\News;
use Em\FrontendBundle\Entity\Images;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class NewsHandler{

    protected  $_form;
    protected  $_request;
    protected  $_em;
    protected  $_news;
    protected  $_timer;
    protected  $_images;

    public  function __construct(Form $form, Request $request, EntityManager $em, \Em\BackendBundle\Entity\News $data = null){

       $this->_form = $form;
       $this->_request = $request;
       $this->_em = $em;
       $this->_news = new News($data)  ;
        $this->_images = new Images();
        $this->_timer = new \Datetime();

    }

    //On verifie la validité des donnees du formulaire

    public  function  process(){

         $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){


            return true;

        }


        return false;

    }
    public  function  processupdate(){

        $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){

            return true;

        }


        return false;

    }
    public  function getForm(){

        return $this->_form;
    }
    //
   public  function  onSuccess($dataImages){

       //On initialise les variable
       $this->_news->setTitle($this->_form->getData()->getTitle()) ;
       $this->_news->setDescription($this->_form->getData()->getDescription()) ;
       $this->_news->setKeywords($this->_form->getData()->getKeywords()) ;
       $this->_news->setDateajout($this->_timer) ;
       $this->_news->setDateedit($this->_timer) ;
       $this->_news->setTitre($this->_form->getData()->getTitre()) ;
       $this->_news->setPublish($this->_form->getData()->getPublish()) ;
       $this->_news->setImages($dataImages);
       $this->_news->setTitle($this->_form->getData()->getTitle()) ;
       $this->_news->setResume($this->_form->getData()->getResume()) ;
       $this->_news->setContenus($this->_form->getData()->getContenus()) ;

       $this->_news->setSlug($this->myslug($this->_form->getData()->getTitle())) ;
       $this->_em->persist($dataImages);

       $this->_em->persist($this->_news);

       $this->_em->flush();
          return true;
   }
    public  function  onSuccessupdate($dataImages, \Em\BackendBundle\Entity\News  $dataNews){

        //On initialise les variable
        // $dataNews represente l entite encours de mdification
        // Chaque proprité sera modifie

        $dataNews->setTitle($this->_form->getData()->getTitle()) ;
        $dataNews->setDescription($this->_form->getData()->getDescription()) ;
        $dataNews->setKeywords($this->_form->getData()->getKeywords()) ;
        $dataNews->setDateedit($this->_timer) ;
        $dataNews->setTitre($this->_form->getData()->getTitre()) ;
        $dataNews->setPublish($this->_form->getData()->getPublish()) ;
        $dataNews->setTitle($this->_form->getData()->getTitle()) ;
        $dataNews->setResume($this->_form->getData()->getResume()) ;
        $dataNews->setContenus($this->_form->getData()->getContenus()) ;

        $dataNews->setSlug($this->myslug($this->_form->getData()->getTitle())) ;
        $dataNews->setImages($dataImages) ;



     //   var_dump($t);exit;
        $this->_em->flush();

        return true;

    }

    /*
  * Function pour remplacer les espaces
  *
  */
    public  function myslug($text){
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

}