<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 20/01/16
 * Time: 14:16
 */

namespace Em\BackendBundle\Form\Handler;

use Doctrine\ORM\EntityManager;


use Em\BackendBundle\Entity\Pub;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PubHandler
{

    protected $_form;
    protected $_request;
    protected $_em;

    public function __construct(Form $form, Request $request, EntityManager $em)
    {

        $this->_form = $form;
        $this->_request = $request;
        $this->_em = $em;
        $this->_pub = new Pub();
    }

    //On verifie la validité des donnees du formulaire

    public function  process()
    {

        $this->_form->handleRequest($this->_request);

        if ($this->_request->isMethod('POST') && $this->_form->isValid()) {

            return true;

        }

        return false;

    }

    public function getForm()
    {

        return $this->_form;
    }
    //
    //
    public function  onSuccess($dataImages)
    {
        // var_dump($dataImages);exit;

        $this->_pub->setImages($dataImages);
        $this->_pub->setTitre($this->_form->getData()->getTitre());
        $this->_pub->setDateadd(new \DateTime());
        $this->_pub->setDatestart($this->_form->getData()->getDatestart());
        $this->_pub->setDateend($this->_form->getData()->getDateend());
        $this->_pub->setPrixstart($this->_form->getData()->getPrixstart());
        $this->_pub->setPourcentage($this->_form->getData()->getPourcentage());
        $this->_pub->setAgences($this->_form->getData()->getAgences());
        $this->_em->persist($dataImages);
        $this->_em->persist($this->_pub);

        $this->_em->flush();
        return true;
    }

}