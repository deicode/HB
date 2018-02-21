<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\FrontendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;
use Em\BackendBundle\Entity\Chambre;
use Em\FrontendBundle\Entity\Commande;
use Em\FrontendBundle\Entity\Reservations;


use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ReservationsHandler{

    protected  $_form;
    protected  $_request;
    protected  $_em;

    public  function __construct(Form $form, Request $request, EntityManager $em){

       $this->_form = $form;
       $this->_request = $request;
       $this->_em = $em;
       $this->_reservations = new Reservations();
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
   public  function  onSuccess($datasession,Chambre $entityChambre){

       $this->_reservations->setNumeroreservation($this->generateToken());
       $this->_reservations->setNom($this->_form->getData()->getNom());
       $this->_reservations->setPhone($this->_form->getData()->getPhone());
       $this->_reservations->setPrenoms($this->_form->getData()->getPrenoms());
       $this->_reservations->setEmail($this->_form->getData()->getEmail());
       $this->_reservations->setModepayement($this->_form->getData()->getModepayement());

       $this->_reservations->setChambre($entityChambre);
       $this->_reservations->setProprietaire($entityChambre->getAgences()->getProprietaire());
       $this->_reservations->setStatus("En cours");

       $this->_reservations->setNbadulte($_POST['adulte']);
       $this->_reservations->setNbenfant($_POST['enfant']);
       $this->_reservations->setNbchambre($_POST['chambre']);
       $this->_reservations->setNbjour($_POST['nbjour']);

       $this->_reservations->setPrixtotal($_POST['prixtotal']);
       $this->_reservations->setDateadd(new \DateTime());
       $this->_reservations->setDatearrivee($_POST['start']);
       $this->_reservations->setDatedepart($_POST['end']);
       $this->_reservations->setTypeaction('RESERVATION');
       //Confirme a false
       //veut dire que l hotelier devra confirmer mettre sa true
       $this->_reservations->setConfirmer(false);
      $this->_em->persist($this->_reservations);


       $this->_em->flush();
       return $this->_reservations;

   }

    protected function generateToken($length=6){

        $num = substr(str_shuffle('abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ1234567890'),rand(0,60-$length),$length);

     /*  $verifnum = $this->_em->getRepository('EmFrontendBundle:Reservations')->findOneBy(array('numeroreservation' => $num));
        if($verifnum){
            $this->generateToken();
        }else{*/
            return $num;
       // }
}
}