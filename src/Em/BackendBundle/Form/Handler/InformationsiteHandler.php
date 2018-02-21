<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Em\BackendBundle\Entity\Informationsite;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class InformationsiteHandler{

    protected  $_form;
    protected  $_request;
    protected  $_em;
    protected  $_informationsite;
    protected  $_timer;

    public  function __construct(Form $form, Request $request, EntityManager $em){

       $this->_form = $form;
       $this->_request = $request;
       $this->_em = $em;
       $this->_informationsite = new Informationsite();
        $this->_timer = new \Datetime();
    }

    //On verifie la validité des donnees du formulaire

    public  function  process(){

         $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){
            //On initialise les variable
            $this->_informationsite->setUrlmap($this->_form->getData()->getUrlmap()) ;
            $this->_informationsite->setTelephone($this->_form->getData()->getTelephone()) ;
            $this->_informationsite->setMobile($this->_form->getData()->getMobile()) ;
            $this->_informationsite->setAdresse($this->_form->getData()->getAdresse());
            $this->_informationsite->setEmail($this->_form->getData()->getEmail());
            $this->_informationsite->setUrlfacebook($this->_form->getData()->getUrlfacebook()) ;
            $this->_informationsite->setDescription($this->_form->getData()->getDescription()) ;


            $this->onSuccess();
            return true;

        }


        return false;

    }
    public  function  processupdate(){

        $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){
            //On initialise les variable
            $this->_informationsite->setUrlmap($this->_form->getData()->getUrlmap()) ;
            $this->_informationsite->setTelephone($this->_form->getData()->getTelephone()) ;
            $this->_informationsite->setMobile($this->_form->getData()->getMobile()) ;
            $this->_informationsite->setAdresse($this->_form->getData()->getAdresse());
            $this->_informationsite->setEmail($this->_form->getData()->getEmail());
            $this->_informationsite->setUrlfacebook($this->_form->getData()->getUrlfacebook()) ;
            $this->_informationsite->setDescription($this->_form->getData()->getDescription()) ;

            $this->onSuccessupdate();

            return true;

        }


        return false;

    }
    public  function getForm(){

        return $this->_form;
    }
    //
   public  function  onSuccess(){
      // var_dump($dataImages);exit;

       $this->_em->persist($this-> _informationsite);

       $this->_em->flush();

   }
    public  function  onSuccessupdate(){
        // var_dump($dataImages);exit;

        $this->_em->flush();

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