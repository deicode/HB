<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Em\BackendBundle\Entity\Slider;
use Em\FrontendBundle\Entity\Images;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;

class SliderHandler{

    protected  $_form;
    protected  $_request;
    protected  $_em;

    public  function __construct(Form $form, Request $request, EntityManager $em){

       $this->_form = $form;
       $this->_request = $request;
       $this->_em = $em;
       $this->_slider = new Slider();
    }

    //On verifie la validité des donnees du formulaire

    public  function  process(){

         $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){

            //On decleche onSuccess
            return true;

        }

        return false;

    }
    public  function getForm(){

        return $this->_form;
    }
    //
   public  function  onSuccess($dataImages){
      // var_dump($dataImages);exit;

      $this->_slider->setImages($dataImages);
      $this->_slider->setTitle($this->_form->getData()->getTitle()) ;
      $this->_slider->setPrix($this->_form->getData()->getPrix());
       $this->_slider->setStatusimmo($this->_form->getData()->getStatusimmo());
       $this->_em->persist($dataImages);
       $this->_em->persist($this->_slider);

       $this->_em->flush();
       return true;
   }
}