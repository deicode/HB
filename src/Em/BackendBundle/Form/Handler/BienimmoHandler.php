<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Em\BackendBundle\Entity\Bienimmo;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BienimmoHandler{

    protected  $_form;
    protected  $_request;
    protected  $_em;
    protected  $_entity;
    protected  $_timer;

    public  function __construct(Form $form, Request $request, EntityManager $em){

       $this->_form = $form;
       $this->_request = $request;
       $this->_em = $em;
       $this->_entity = new Bienimmo();
        $this->_timer = new \Datetime();
    }

    //On verifie la validité des donnees du formulaire

    public  function  process(){

         $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){
            //On initialise les variable

            //On verifie si la ville a enregistrer existe
            $entity = $this->_em->getRepository('EmBackendBundle:Bienimmo')->findBy(array('libelle' =>$this->_form->getData()->getLibelle()));
          if($entity){
              throw new NotFoundHttpException('Désolé cette valeur existe dejà !');
          }


            return true;

        }


        return false;

    }
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
   public  function  onSuccess(){
      // var_dump($dataImages);exit;

       $this->_entity = $this->_form->getData();

       $this->_entity->setReference(date('YmdHis')) ;
       $this->_entity->setDateadd($this->_timer);
       $this->_entity->setLocked(true);

       return $this->_entity;
   }
    public  function  onSuccessupdate($dataEntity){



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