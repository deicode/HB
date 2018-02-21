<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Em\BackendBundle\Entity\Agences;
use Em\BackendBundle\Form\Type\AgencesType;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AgencesHandler{

    protected  $_form;
    protected  $_request;
    protected  $_em;

    public  function __construct(Form $form, Request $request, EntityManager $em){

       $this->_form = $form;
       $this->_request = $request;
       $this->_em = $em;
       $this->_agence = new Agences();
    }

    //On verifie la validité des donnees du formulaire

    public  function  process(){

         $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){

            return true;

        }

        return false;

    }


    //update function
    public  function  processupdate(){



        if($this->_request->isMethod('POST')){
            //On initialise les variable

            return true;

        }


        return false;

    }

    public  function getForm(){

        return $this->_form;
    }
    //
   public  function  onSuccess($user){
       $commune = null;

       //Verification
       //On regupere la ville

       //On recupere la commune

       //on recupere le user en cours
      $hotelier =  $this->_em->getRepository('EmBackendBundle:Agences')->findOneBy(array('proprietaire' => $user->getId()));
          //On verifie s'il existe deja en agence
       $this->_agence =$this->_form->getData();
       $this->_agence->setDateadd(new \DateTime()) ;

       $this->_agence->setProprietaire($user);
       return $this->_agence ;
   }

    public  function  onSuccessupdate($agences){



        $this->_em->flush();
        return true;

    }

}