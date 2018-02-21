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
use Em\BackendBundle\Entity\Commentaire;
use Em\BackendBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Client;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentaireHandler
{

    protected $_form;
    protected $_request;
    protected $_em;
    protected $_entyuser ;
    protected $_entityagence;
    protected $_commentaire;

    public  function __construct(Form $form, Request $request, EntityManager $em,  $agenceentity,  $userentity)
    {

        $this->_form = $form;
        $this->_request = $request;
        $this->_em = $em;
        $this->_commentaire = new Commentaire();
        $this->_entityagence = $agenceentity ;
        $this->_entyuser = $userentity  ;
    }

    //On verifie la validité des donnees du formulaire

    public  function  process($client,  $agence)
    {



        if ($this->_request->isMethod('POST') ) {


            $this->onSuccess($client,  $agence);
            return true;

        }

        return false;

    }

    public function getForm()
    {
        /*$this->_commentaire->setAgences($this->_entityagence) ;
        $this->_commentaire->setClient($this->_entyuser)  ;*/
        return $this->_form;
    }
    //
    //
    public function  onSuccess( $client,  $agence)
    {
        // var_dump($dataImages);exit;


        $this->_commentaire->setTitre($_POST['commentaire']['titre']);
        $this->_commentaire->setContenu($_POST['commentaire']['contenu']);
        $this->_commentaire->setNote($_POST['commentaire']['note']);
        $this->_commentaire->setEnabled(false);
        $this->_commentaire->setEnabledhome(false);
        $this->_commentaire->setDateadd(new \DateTime());
        $this->_commentaire->setClient($client);
        $this->_commentaire->setAgences($agence);
 
        $this->_em->persist($this->_commentaire);

        $this->_em->flush();

    }

}