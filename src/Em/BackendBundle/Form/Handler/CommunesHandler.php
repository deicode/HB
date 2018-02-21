<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Em\BackendBundle\Entity\Communes;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommunesHandler{

    protected  $_form;
    protected  $_request;
    protected  $_em;
    protected  $_communes;
    protected  $_timer;

    public  function __construct(Form $form, Request $request, EntityManager $em){

       $this->_form = $form;
       $this->_request = $request;
       $this->_em = $em;
       $this->_communes = new Communes();
        $this->_timer = new \Datetime();
    }

    //On verifie la validité des donnees du formulaire

    public  function  process(){

         $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){
            //On initialise les variable

            //On verifie si la ville a enregistrer existe
            $communes = $this->_em->getRepository('EmBackendBundle:Communes')->findBy(array('nom' =>$this->_form->getData()->getNom()));
            $villes = $this->_em->getRepository('EmBackendBundle:Villes')->findOneBy(array('nom' => $this->_form->getData()->getVilles()->getNom()));

            if($communes || !$villes){
              throw new NotFoundHttpException('Désolé votre requete est erronée !');
          }

            $this->_communes->setNom(strtoupper($this->_form->getData()->getNom())) ;
            $this->_communes->setDescription($this->_form->getData()->getDescription()) ;
            $this->_communes->setUrlmap($this->_form->getData()->getUrlmap()) ;
            $this->_communes->setVilles($villes);
            $this->_communes->setSlug($this->myslug($this->_form->getData()->getNom())) ;
            $this->onSuccess();
            return true;

        }


        return false;

    }
    public  function  processupdate(){

        $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){
            //On initialise les variable
            $this->_communes->setNom(strtoupper($this->_form->getData()->getNom())) ;
            $this->_communes->setDescription($this->_form->getData()->getDescription()) ;
            $this->_communes->setUrlmap($this->_form->getData()->getUrlmap()) ;

            $this->_communes->setSlug($this->myslug($this->_form->getData()->getNom())) ;
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

       $this->_em->persist($this->_communes);

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