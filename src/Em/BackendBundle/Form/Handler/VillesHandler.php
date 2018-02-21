<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Em\BackendBundle\Entity\Villes;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class VillesHandler{

    protected  $_form;
    protected  $_request;
    protected  $_em;
    protected  $_villes;
    protected  $_timer;

    public  function __construct(Form $form, Request $request, EntityManager $em){

       $this->_form = $form;
       $this->_request = $request;
       $this->_em = $em;
       $this->_villes = new Villes();
        $this->_timer = new \Datetime();
    }

    //On verifie la validité des donnees du formulaire

    public  function  process(){

         $this->_form->handleRequest($this->_request);

        if($this->_request->isMethod('POST') && $this->_form->isValid()){
            //On initialise les variable

            //On verifie si la ville a enregistrer existe
            $villes = $this->_em->getRepository('EmBackendBundle:Villes')->findBy(array('nom' =>$this->_form->getData()->getNom()));
          if($villes){
              throw new NotFoundHttpException('Désolé cette ville existe dejà !');
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
       $this->_villes->setNom(strtoupper($this->_form->getData()->getNom())) ;
       $this->_villes->setDescription($this->_form->getData()->getDescription()) ;
       $this->_villes->setSlug($this->myslug($this->_form->getData()->getNom())) ;
       $this->_villes->setPays($this->_form->getData()->getPays()) ;

       $this->_em->persist($this-> _villes);
       $this->_em->flush();
       return true;
   }
    public  function  onSuccessupdate( $dataEntity){
        $intpays = (int) $_POST['villes']['pays'];
        $pays = $this->_em->getRepository('EmBackendBundle:Pays')->findOneBy(array('id' => $intpays));
        if(!$pays){
            throw new NotFoundHttpException('error');
        }
        $dataEntity->setNom($_POST['villes']['nom']) ;
        $dataEntity->setDescription($_POST['villes']['description']) ;

        $dataEntity->setSlug($this->myslug($_POST['villes']['nom'])) ;
        $dataEntity->setPays($pays) ;
        // var_dump($this->_villes);die;



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