<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Em\BackendBundle\Entity\Pagesite;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class PagesiteHandler{

    protected  $_form;
    protected  $_request;
    protected  $_em;
    protected  $_pagesite;
    protected  $_timer;

    public  function __construct(Form $form, Request $request, EntityManager $em){

       $this->_form = $form;
       $this->_request = $request;
       $this->_em = $em;
       $this->_pagesite = new Pagesite();
        $this->_timer = new \Datetime();
    }

    //On verifie la validité des donnees du formulaire

    public  function  process(){

         $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){
            //On initialise les variable
            $this->_pagesite->setTitle($this->_form->getData()->getTitle()) ;
            $this->_pagesite->setDescription($this->_form->getData()->getDescription()) ;
            $this->_pagesite->setKeywords($this->_form->getData()->getKeywords()) ;
            $this->_pagesite->setDateupdate($this->_timer) ;
            $this->_pagesite->setTitre($this->_form->getData()->getTitre()) ;
            $this->_pagesite->setTitle($this->_form->getData()->getTitle()) ;
            $this->_pagesite->setBlock($this->_form->getData()->getBlock()) ;
            $this->_pagesite->setContenu($this->_form->getData()->getContenu()) ;

            $this->_pagesite->setSlug($this->myslug($this->_form->getData()->getTitle())) ;


            $this->onSuccess();
            return true;

        }


        return false;

    }
    public  function  processupdate(){

        $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST')){


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

       $this->_em->persist($this-> _pagesite);

       $this->_em->flush();

   }
    public  function  onSuccessupdate($entity){
        // var_dump($dataImages);exit;
//On initialise les variable
        $entity->setTitle($this->_form->getData()->getTitle()) ;
        $entity->setDescription($this->_form->getData()->getDescription()) ;
        $entity->setKeywords($this->_form->getData()->getKeywords()) ;
        $entity->setDateupdate($this->_form->getData()->getDateupdate());
        $entity->setTitre($this->_form->getData()->getTitre()) ;
        $entity->setTitle($this->_form->getData()->getTitle()) ;
        $entity->setBlock($this->_form->getData()->getBlock()) ;
        $entity->setContenu($this->_form->getData()->getContenu()) ;

       $entity->setSlug($this->myslug($this->_form->getData()->getTitle())) ;

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