<?php

namespace Em\ClientBundle\Controller;

use Em\BackendBundle\Form\Type\ParamType;
use Em\ClientBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ClientController extends Controller
{
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $datareservation = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array('email' => $user->getEmail()));

        // var_dump($dataagence);exit;
        // on recupere toutes les communes

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $datareservation,
            $request->query->get('tracker', 1)/*page number*/,
            15/*limit per page*/
        );
        //redirige si utilisateur est proprietaire
        if($this->isGranted('ROLE_PROPRIETAIRE') ){
            return $this->redirect($this->generateUrl('em_backend_proprietaire_homepage'));
        }
        return $this->render('EmClientBundle:Client:Layouts/index.html.twig',array('datareservation' => $pagination, 'user'=> $this->getUser()));
    }

    public function  parametreAction(Request $request){

         $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        if(!$user){
            throw new NotFoundHttpException('Utilisateur inexsitant' );
        }
        $form = $this->createForm(new ParamType(), $user);

        if($request->isMethod('POST')){
            $nom = (isset($_POST['param']['nom'])) ? $_POST['param']['nom'] : null;
            $ville= (isset($_POST['param']['ville'])) ? $_POST['param']['ville'] : null;
            $adresse = (isset($_POST['param']['adresse'])) ? $_POST['param']['adresse'] : null;
            $pays = (isset($_POST['param']['pays'])) ? $_POST['param']['pays'] : null;
            $phone = (isset($_POST['param']['phone'])) ? $_POST['param']['phone'] : null;

            $user->setNom($nom);
            $user->setVille($ville);
            $user->setAdresse($adresse);
            $user->setPays($pays);
            $user->setPhone($phone);

            $em->flush();
            $request->getSession()->getFlashBag()->add('Notice', $user->getUsername().' vos paramètres ont été modifié avec succès!');
            return $this->redirect($this->generateUrl('em_client_homepage'));

        }

        return $this->render('EmClientBundle:Client:Layouts/parametre.html.twig',array('form' => $form->createView(), 'user'=> $this->getUser()));

    }

    public function renderMenuLeftAction(){
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('::client/blocks/menuLeft.html.twig', array( 'user' => $user));

    }

    public function mesReservationsAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        //on recupere les reservations du client conncté

        $reservations = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array('email' => $user->getEmail()), array('id' => 'DESC'));

        return $this->render('EmClientBundle:Client:Layouts/mesreservation.html.twig', array('mesreservations' => $reservations, 'user'=> $user));
    }

    public function commentaireAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        //on recupere les reservations du client conncté

        $hotels = $em->getRepository('EmBackendBundle:Agences')->findAll();

        return $this->render('EmClientBundle:Client:Layouts/commentaire.html.twig', array('hotels' => $hotels));
    }

    public function reservationDetailsAction($idreservation = null){

        $reservationid = $this->get('nzo_url_encryptor')->decrypt($idreservation) ;

        $em = $this->getDoctrine()->getManager();
        $datareservation = $em->getRepository('EmFrontendBundle:Reservations')->findOneBy(array('id' => $reservationid));

        // var_dump($dataagence);exit;
        // on recupere toutes les communes
        if(!$datareservation){
            throw new NotFoundHttpException('Oups une erreur à été rencontrée ! ');
        }

        return $this->render('EmClientBundle:Client:Layouts/details.html.twig', array('reservation' => $datareservation));

    }

    public function renderConnexionClientAction(){

        $em = $this->getDoctrine()->getManager();
        $texte = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("titre"=> 'Connexion client'));


        return $this->render('EmClientBundle:Security:loginText.html.twig', array( 'texte' => $texte));

    }

    public function renderEnregistrementClientAction(){

        $em = $this->getDoctrine()->getManager();
        $texte = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("titre"=> 'Enregistrement client'));


        return $this->render('EmClientBundle:Registration:enregistrementText.html.twig', array( 'texte' => $texte));

    }

}
