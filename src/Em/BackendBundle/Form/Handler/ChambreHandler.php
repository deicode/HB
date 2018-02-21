<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Em\BackendBundle\Entity\Chambre;

use Em\BackendBundle\Form\ChambreType;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ChambreHandler{

    protected  $_form;
    protected  $_request;
    protected  $_em;

    public  function __construct(Form $form, Request $request, EntityManager $em){

       $this->_form = $form;
       $this->_request = $request;
       $this->_em = $em;
       $this->_chambre = new Chambre();
    }

    //On verifie la validité des donnees du formulaire

    public  function  process(){

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
   public  function  onSuccess($agences, $dataimages){


     // $agence =  $this->_em->getRepository('EmBackendBundle:Agences')->findOneBy(array('hotelier' => $user->getId()));
          //On verifie s'il existe deja en chambre

       if( !$agences){
           throw new NotFoundHttpException('Attention une agence doit être créee au préalable ! ');
       }
       $this->_chambre = $this->_form->getData();
    //slug chambre
       $this->_chambre->setSlugchambre($this->myslug($this->_form->getData()->getTypechambre()));
     // date ajout
       $this->_chambre->setDateadd(New \DateTime());

       $this->_chambre->setAgences($agences);
       $this->_chambre->setImages($dataimages);
       $this->_em->persist($dataimages);
       $this->_em->persist($this->_chambre);
       $this->_em->flush();
       return $this->_chambre;
   }


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