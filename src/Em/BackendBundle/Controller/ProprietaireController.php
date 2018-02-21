<?php

namespace Em\BackendBundle\Controller;

use Em\BackendBundle\Entity\Agences;
use Em\BackendBundle\Entity\Chambre;
use Em\BackendBundle\Entity\Bienimmo;
use Em\BackendBundle\Form\Type\AgencesImmoType;
use Em\BackendBundle\Form\Type\AgencesType;
use Em\BackendBundle\Form\Type\ChambreType;
use Em\BackendBundle\Form\Type\BienimmoType;
use Em\BackendBundle\Form\Handler\AgencesHandler;
use Em\BackendBundle\Form\Handler\ChambreHandler;
use Em\BackendBundle\Form\Handler\UploadHandler;
use Em\BackendBundle\Form\Handler\BienimmoHandler;

use Em\BackendBundle\Form\Type\ParamType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ProprietaireController extends Controller
{
    /*
     * Gestion des proprietaires
    */
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $hotels = $em->getRepository('EmBackendBundle:Agences')->findOneBy(array('proprietaire' => $user->getId(), 'caracteristique'=>'Hotel'));
        $residence = $em->getRepository('EmBackendBundle:Agences')->findOneBy(array('proprietaire' => $user->getId(), 'caracteristique'=>'Residence'));
        $appartement= $em->getRepository('EmBackendBundle:Agences')->findOneBy(array('proprietaire' => $user->getId(), 'caracteristique'=>'Appartement'));
       $immobilierSom = count($residence) + count($appartement);

        // $agences = $em->getRepository('EmBackendBundle:Vehicules')->findOne(array('proprietaire' => $user->getId()));
        $datareservation = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array('proprietaire' => $user, 'confirmer'=> false), array('id' =>'DESC'));

       //Total transaction


        $prixtotalAll = 0;
        $reservationConfirme = $em->getRepository('EmFrontendBundle:Reservations')->findReservationBYHotelier($user);

        foreach($reservationConfirme as $obj){
            $prixtotalAll += $obj->getPrixtotal() ;
            $obj->setPrixtotal($obj->getPrixtotal());

        }
       // $prixtotalAll = $prixtotalAll;


        return $this->render('::BackendV2/proprietaire/files/index.html.twig',array(
            'hotelssom'=> count($hotels),
            'reservation' => $datareservation,
            'immobilierssom' => $immobilierSom,
             'montanttransaction' => $prixtotalAll ,
            'proprietaire' =>  $user));
    }


    public function  listeHotelierAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $hoteliers = $em->getRepository('EmBackendBundle:User')->findByRoleAndStatus('ROLE_PROPRIETAIRE', true);
        $hoteliersall = $em->getRepository('EmBackendBundle:User')->findBy(array('roles'=>'ROLE_PROPRIETAIRE'),array('id' => 'DESC'));
        $hotel= $em->getRepository('EmBackendBundle:Agences')->findBy(array('locked'=>0),array('id' => 'DESC'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hotel,
            $request->query->get('tracker', 1)/*page number*/,
            8/*limit per page*/
        );

        return $this->render('EmBackendBundle:Backend:file/listehoteliers.html.twig',array('pagination' =>  $pagination, 'hoteliersall' =>$hoteliersall) );

    }

    public function detailHotelAction(Request $request, $id=null){

        $em = $this->getDoctrine()->getManager();
        $hotel= $em->getRepository('EmBackendBundle:Agences')->find($id);
        $imagehotel = $em->getRepository('EmBackendBundle:Imagesmultiple')->findByAgence($hotel->getId());
        $chambre = $em->getRepository('EmBackendBundle:Chambre')->findByAgences($hotel->getId());
        $imageallchambre=array();
        foreach ($chambre as $key => $value) {
            $imageallchambre[$key] = $em->getRepository('EmBackendBundle:Imagesmultiplechambre')->findBy(array('chambre'=>$value->getId()));
        }
        /*
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hotel,
            $request->query->get('tracker', 1),//page number
            10//limit per page
        );
        */

        return $this->render('::Backend/proprietaire/files/detailagence.html.twig',array('hotel'=>$hotel, 'imagehotel'=>$imagehotel, 'chambre'=>$chambre, 'imageallchambre' => $imageallchambre, 'proprietaire'=> $this->getUser()));

    }

    public function  listeImmoAction(Request $request){
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $liste = $em->getRepository('EmBackendBundle:Agences')->recupListeImmoByuser($user->getId());
        //$hoteliersall = $em->getRepository('EmBackendBundle:Bienimmo')->findAll();


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $liste,
            $request->query->get('tracker', 1)/*page number*/,
            25/*limit per page*/
        );

        return $this->render('::BackendV2/proprietaire/files/listeimmo.html.twig',array('pagination' =>  $pagination,
            'entity' =>$liste, 'proprietaire' => $user) );

    }
    public function  listeHotelsAction(Request $request){
        $user = $this->getUser();
        $em = $this->getDoctrine()->getManager();
        $liste = $em->getRepository('EmBackendBundle:Agences')->recupListeHotelByuser($user->getId());
        //$hoteliersall = $em->getRepository('EmBackendBundle:Bienimmo')->findAll();


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $liste,
            $request->query->get('tracker', 1)/*page number*/,
            25/*limit per page*/
        );

        return $this->render('::BackendV2/proprietaire/files/listehotel.html.twig',array('pagination' =>  $pagination,
            'entity' =>$liste, 'proprietaire' => $user) );

    }

    public function addBiensAction(Request $request){
        //Appel su service slide handler
        //On lien du dossier d upload
        $lienDossier = '/../../../../../web/bundles/emfrontend/assets/pics/agences/';

        //appel de la class gestion des upload
        $em = $this->getDoctrine()->getManager();
        $biensHandler = new BienimmoHandler($this->createForm(new BienimmoType(), new Bienimmo()), $request, $em);

        $uploadHandler = new UploadHandler($this->createForm(new AgencesType(), new Agences()), $request, $em, $lienDossier);

        if ($biensHandler->process()) {
            $user = $this->container->get('security.context')->getToken()->getUser();
            $entityAgence = $biensHandler->onSuccess($user);
            $entityChambre = new Chambre();

            if (!empty($entityAgence)) {
                if ($uploadHandler->uploadMultipleImagesAgence($lienDossier, $entityAgence)) {
                    $request->getSession()->getFlashBag()->add('notice', ' Votre agence est en attente de validation!');
                        //envoie de mail
                    return $this->redirect($this->generateUrl('em_backend_listebiens',array('id' => $entityAgence->getId())));
                }
            } else {
                //On declenche une erreur lié a l'upload image
                throw $this->createNotFoundException(
                    'Error of sytème ! ');
            }

        }

        return $this->render('EmBackendBundle:Backend:file/addbienimmo.html.twig',array('form' => $biensHandler->getForm()->createView()));


    }

    public function listeReservationRecenteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $allreservation = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array('proprietaire' => $user, 'confirmer'=> false), array('id' => 'DESC'));
        
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $allreservation,
            $request->query->get('tracker', 1)/*page number*/,
            25/*limit per page*/
        );
        return $this->render('::BackendV2/proprietaire/files/listereservationrecente.html.twig',array('entity' =>  $pagination, 'allreservation' =>$allreservation, 'proprietaire' =>$user));
    }

    public function listeReservationHistoriqueAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $allreservation = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array('proprietaire' => $user, 'confirmer'=> true), array('id' => 'DESC'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $allreservation,
            $request->query->get('tracker', 1)/*page number*/,
            50/*limit per page*/
        );
        return $this->render('::BackendV2/proprietaire/files/listereservationhistorique.html.twig',array('entity' =>  $pagination, 'allreservation' =>$allreservation, 'proprietaire' =>$user));
    }

    public function  listenewsHotelierNewsAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $hoteliersnews = $em->getRepository('EmBackendBundle:User')->findByRoleAndStatus('ROLE_SUPER_ADMIN', false);
        $hoteliersall = $em->getRepository('EmBackendBundle:User')->findByRole('ROLE_SUPER_ADMIN');

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $hoteliersnews,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('EmBackendBundle:Backend:file/listenouveauxhoteliers.html.twig',array('pagination' =>  $pagination, 'hoteliersall' =>$hoteliersall) );

    }

    public function enabledAction(Request $request ,$iduser, $status){

        if($status === 'valider' || $status === 'suspendre'){
            $em = $this->getDoctrine()->getManager();
            $user = $em->getRepository('EmBackendBundle:User')->find($iduser);
              if(!$user){

                  throw new NotFoundHttpException('Le Système a rencontré une erreur contacter Agence E-mitic !');
              }
             if($status === 'valider'){
                 $user->setEnabled(true);
             }elseif($status === 'suspendre'){
                 $user->setEnabled(false);
             }

            $em->flush();
            $request->getSession()->getFlashBag()->add('Notice',  "Vous venez de $status  un utilisteur avec succès !");
            return $this->redirect($this->generateUrl('em_backend_homepage'));
        }
        return $this->redirect($this->generateUrl('em_backend_homepage'));

    }



    public function enabledAgenceAction(Request $request ,$idagence, $status){

        if($status === 'valider' || $status === 'suspendre'){
            $em = $this->getDoctrine()->getManager();
            $agence = $em->getRepository('EmBackendBundle:Agences')->find($idagence);
            if(!$agence){

                throw new NotFoundHttpException('Le Système a rencontré une erreur contacter Agence E-mitic !');
            }
            if($status === 'valider'){
                $agence->setLocked(false);
            }elseif($status === 'suspendre'){
                $agence->setLocked(true);
            }

            $em->flush();
            $request->getSession()->getFlashBag()->add('Notice',  "Vous venez de $status  une Agence hôtelière avec succès !");
            return $this->redirect($this->generateUrl('em_backend_homepage'));
        }
        return $this->redirect($this->generateUrl('em_backend_homepage'));

    }

    public function enabledChambreAction(Request $request ,$idchambre, $status){

        if($status === 'valider' || $status === 'suspendre'){
            $em = $this->getDoctrine()->getManager();
            $chambre = $em->getRepository('EmBackendBundle:Chambre')->find($idchambre);
            if(!$chambre){

                throw new NotFoundHttpException('Le Système a rencontré une erreur contacter Agence E-mitic !');
            }
            if($status === 'valider'){
                $chambre->setLocked(false);
            }elseif($status === 'suspendre'){
                $chambre->setLocked(true);
            }

            $em->flush();
            $request->getSession()->getFlashBag()->add('Notice',  "Vous venez de $status  une chambre avec succès !");
            return $this->redirect($this->generateUrl('em_backend_homepage'));
        }
        return $this->redirect($this->generateUrl('em_backend_homepage'));

    }


    public function addAgencesAction(Request $request){
        //Appel su service slide handler
        //On lien du dossier d upload
        $lienDossier = '/../../../../../web/bundles/emfrontend/assets/pics/agences/';
        $user = $this->container->get('security.context')->getToken()->getUser();

        //appel de la class gestion des upload
        $em = $this->getDoctrine()->getManager();
        $agencesHandler = new AgencesHandler($this->createForm(new AgencesType(), new Agences()), $request, $em);

        $uploadHandler = new UploadHandler($this->createForm(new AgencesType(), new Agences()), $request, $em, $lienDossier);

        if ($agencesHandler->process()) {
            $entityAgence = $agencesHandler->onSuccess($user);
            $entityChambre = new Chambre();

            if (!empty($entityAgence)) {
                if ($uploadHandler->uploadMultipleImagesAgence($lienDossier, $entityAgence)) {
                    $request->getSession()->getFlashBag()->add('notice', ' Votre agence est en attente de validation!');
                        //envoie de mail
                    return $this->redirect($this->generateUrl('em_backend_proprietaire_listesingleagence',array('id' => $entityAgence->getId())));
                }
            } else {
                //On declenche une erreur lié a l'upload image
                throw $this->createNotFoundException(
                    'Error of sytème  ! ');
            }

        }

        return $this->render('::BackendV2/proprietaire/files/addagence.html.twig',array('form' => $agencesHandler->getForm()->createView(), 'proprietaire'=> $user));


    }

    public function addAgenceImmoAction(Request $request){
        //Appel su service slide handler
        //On lien du dossier d upload
        $lienDossier = '/../../../../../web/bundles/emfrontend/assets/pics/agences/';
        $user = $this->container->get('security.context')->getToken()->getUser();

        //appel de la class gestion des upload
        $em = $this->getDoctrine()->getManager();
        $agencesHandler = new AgencesHandler($this->createForm(new AgencesImmoType(), new Agences()), $request, $em);

        $uploadHandler = new UploadHandler($this->createForm(new AgencesImmoType(), new Agences()), $request, $em, $lienDossier);

        if ($agencesHandler->process()) {
            $entityAgence = $agencesHandler->onSuccess($user);
            $entityChambre = new Chambre();

            if (!empty($entityAgence)) {
                if ($uploadHandler->uploadMultipleImagesAgence($lienDossier, $entityAgence)) {
                    $request->getSession()->getFlashBag()->add('notice', ' Votre agence a été ajouté avec succès!');
                    //envoie de mail
                    return $this->redirect($this->generateUrl('em_backend_proprietaire_listesingleagence',array('id' => $entityAgence->getId())));
                }
            } else {
                //On declenche une erreur lié a l'upload image
                throw $this->createNotFoundException(
                    'Error of sytème  ! ');
            }

        }

        return $this->render('::BackendV2/proprietaire/files/addagenceimmo.html.twig',array('form' => $agencesHandler->getForm()->createView(), 'proprietaire'=> $user));


    }



    public function updateAgencesAction(Request $request, Agences $agences){


        //appel de la class gestion des upload
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $entity = $em->getRepository('EmBackendBundle:Agences')->findOneBy(array('proprietaire' =>$user), array());


            if(!$entity){
                return $this->redirect($this->generateUrl('em_backend_proprietaire_addagence'));
            }

        $Handler = $this->createForm( new AgencesType(), $entity);

        if ($request->getMethod() == 'POST') {

            $Handler->handleRequest($request);

            if ($Handler->isValid()) {
               $entity->setProprietaire($user);

                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', ' Mise à jour Agence ,effectuée avec succès!');

                return $this->redirect($this->generateUrl('em_backend_proprietaire_detailagence', array('id' => $user->getId())));


            }
        }


        return $this->render('::BackendV2/proprietaire/files/addagence.html.twig',array('form' => $Handler->createView(), 'entity'=> $entity, 'proprietaire'=> $this->getUser()));


    }


    public function listeSingleAgenceAction(Request $request , $iduser = null){

        $em = $this->getDoctrine()->getManager();

        //On recupere l'utilisateur en cours !
        if($iduser == null || $iduser === 'me'){
            $user = $this->container->get('security.context')->getToken()->getUser() ;
        }elseif(!empty($iduser)){

            $user = $em->getRepository('EmBackendBundle:User')->find($iduser);
        }


        if(!$user){

            $request->getSession()->getFlashBag()->add('Notice',  "Erreur: Utilisateur inexistante!");
            return $this->redirect($this->generateUrl('em_backend_homepage'));
        }

        //On emploie une requete sur la table Agence pr recupere ses data

        $agence = $em->getRepository('EmBackendBundle:Agences')->findOneBy(array('proprietaire' => $user));

        //On verifie l entite
        if(!$agence){
            //return $this->redirect($this->generateUrl('em_backend_listehoteliers'));
            $request->getSession()->getFlashBag()->add('Notice', ' Oups vous n\'avez aucune agence , Veuillez l\'inscrire !');
            return $this->redirect($this->generateUrl('em_backend_proprietaire_addagence'));
        }
        if($agence->getId() == null){
            $request->getSession()->getFlashBag()->add('Notice', ' Oups ce proprietaire n\'a aucune agence  Merci de le contacter');
            return $this->redirect($this->generateUrl('em_backend_listehoteliers'));
        }

        $imageagence = $em->getRepository('EmBackendBundle:Imagesmultiple')->findBy(array('agence' => $agence), array('id' => 'DESC'));

        return $this->render('::BackendV2/proprietaire/files/detailagence.html.twig', array('agence' => $agence, 'imageagence' =>  $imageagence, 'users' =>$user, 'proprietaire' => $this->getUser()));

    }





    public function listeAllAgenceAction(){

    }


    public function  addChambreAction(Request $request, Agences $agences = null){

        //Appel su service slide handler
        //On lien du dossier d upload
        $lienDossier = '/../../../../../web/bundles/emfrontend/assets/pics/chambres/';

        //appel de la class gestion des upload
        $em = $this->getDoctrine()->getManager();
    //    $user = $this->container->get('security.context')->getToken()->getUser();

        $chambreHandler = new ChambreHandler($this->createForm(new ChambreType(), new Chambre()), $request, $em);

        $uploadHandler = new UploadHandler($this->createForm(new ChambreType(), new Chambre()),  $request, $em, $lienDossier);

       // $agence =  $em->getRepository('EmBackendBundle:Agences')->findOneBy(array('hotelier' => $user->getId()));
        //On verifie s'il existe deja en chambre

        if( $agences == null){
            throw new NotFoundHttpException('Attention Action impossible ! ');
        }
        if ( $chambreHandler->process()) {


            $dataImages = $uploadHandler->uploadImages('chambre');


            if (!empty($dataImages)) {
                $entitychambre =  $chambreHandler->onSuccess($agences,$dataImages);
                if ( $entitychambre) {

                    $request->getSession()->getFlashBag()->add('Notice', 'Chambre ajoutée avec succès!');
                    //envoie de mail
                    return $this->redirect($this->generateUrl('em_backend_proprietaire_homepage'));
                }
            } else {
                //On declenche une erreur lié a l'upload image
                throw $this->createNotFoundException(
                    'Error of système  ! ');
            }

        }
        return $this->render('::BackendV2/proprietaire/files/addchambre.html.twig',array('form' => $chambreHandler->getForm()->createView(), 'agences' => $agences, 'proprietaire' => $this->getUser()));

    }

    /*
     * Les renders controller
     */

    //Venant d un render
    public function  lastHotelierValiderAction(){
        $em = $this->getDoctrine()->getManager();
        $hoteleierslastvalide = $em->getRepository('EmBackendBundle:User')->findByRoleAndStatus('ROLE_PROPRIETAIRE', false);
        return $this->render('EmBackendBundle:Backend:twigrender/lastvalidehotelier.html.twig',array('hoteleierslastvalide' =>  $hoteleierslastvalide) );

    }

    //Venant d un render
    public function  dashboardAdminAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        if(!$this->get('security.context')->isGranted('ROLE_SUPERVISEUR')){

            throw new NotFoundHttpException(' Accès interdit ! vous n\'avez pas les droits');
        }
        return $this->render('EmBackendBundle:Backend:twigrender/dashboardadmin.html.twig', array('user' => $user) );

    }
    //Venant d un render
    public function  dashboardHotelierAction(){
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        if(!$this->get('security.context')->isGranted('ROLE_PROPRIETAIRE')){

           throw new NotFoundHttpException(' Accès interdit ! vous n\'avez pas les droits');
        }


        return $this->render('EmBackendBundle:Backend:twigrender/dashboardhotelier.html.twig', array('user' => $user) );

    }

    //Venant d un render
    public function  nouvelleAgenceAction(){
        if(!$this->get('security.context')->isGranted('ROLE_SUPERVISEUR')){

            throw new NotFoundHttpException(' Accès interdit ! vous n\'avez pas les droits');
        }

        $em = $this->getDoctrine()->getManager();
        $agence = $em->getRepository('EmBackendBundle:Agences')->findBy(array('locked' => true));
        $imageagence = $em->getRepository('EmBackendBundle:Imagesmultiple')->findBy(array('agence' => $agence), array('id' => 'DESC'));
        return $this->render('EmBackendBundle:Backend:twigrender/nouvelleagence.html.twig', array('agence' => $agence, 'images' => $imageagence) );

    }


    //Venant d un render
    public function  nouvelleChambreAction(){
        if(!$this->get('security.context')->isGranted('ROLE_SUPERVISEUR')){

            throw new NotFoundHttpException(' Accès interdit ! vous n\'avez pas les droits');
        }

        $em = $this->getDoctrine()->getManager();
        $chambre = $em->getRepository('EmBackendBundle:Chambre')->findBy(array('locked' => true));
        return $this->render('EmBackendBundle:Backend:twigrender/nouvellechambre.html.twig', array('chambre' => $chambre) );

    }

    //Venant d un render

    public function  detailChambreAction(Request $request, Agences $agences = null,$slugchambre = null ){
        $em = $this->getDoctrine()->getManager();

        if(!$agences ){
            throw new NotFoundHttpException(' Erreur : requete invalide !');
        }

            $chambre = $em->getRepository('EmBackendBundle:Chambre')->typeChambreBlock($agences, $slugchambre);
            $datareservation = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array('chambre' => $chambre), array('id' => 'DESC'));



        //On recupere la chmabre

        if($chambre->getId() == null){
            $request->getSession()->getFlashBag()->add('Notice', ' Désolé vous n\'avez pas encore de  '.$slugchambre.'  Merci de l\'ajouter ici ');
            //envoie de mail
            return $this->redirect($this->generateUrl('em_backend_addchambre'));
        }
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $datareservation,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('EmBackendBundle:Backend:file/detailchambre.html.twig', array('chambre' => $chambre,'reservation' => $pagination));

    }


    public function  parametresAction(Request $request,  $iduser= null){

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('EmBackendBundle:User')->find($iduser);

        if(!$user){
            throw new NotFoundHttpException('Utilisateur inexsitant' );
        }
        $form = $this->createForm(new ParamType(), $user);

        if($request->isMethod('POST')){
            $user->setNom($_POST['param']['nom']);
            $user->setVille($_POST['param']['ville']);
            $user->setAdresse($_POST['param']['adresse']);
            $user->setPays($_POST['param']['pays']);
            $user->setPhone('225'.$_POST['param']['phone']);

            $em->flush();
            $request->getSession()->getFlashBag()->add('Notice', ' Vos paramètres ont été modifié avec succès!');
            return $this->redirect($this->generateUrl('em_backend_proprietaire_homepage'));

        }

        return $this->render('::BackendV2/proprietaire/files/parametres.html.twig',array('form' => $form->createView(), 'proprietaire'=> $user));

    }

    public function monCoffreProprietaireAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $agence = $em->getRepository('EmBackendBundle:Agences')->findOneBy(array('proprietaire'=>$user));

        $pourcentagecommercial = (int) $agence->getPourcentagecommercial();

        $reservationConfirme = $em->getRepository('EmFrontendBundle:Reservations')->findReservationBYHotelier($user);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $reservationConfirme,
            $request->query->get('tracker', 1)/*page number*/,
            50/*limit per page*/
        );

        $prixtotalAll = 0;

        foreach($reservationConfirme as $obj){
            $prixtotalAll += $obj->getPrixtotal() ;
            $obj->setPrixtotal(number_format($obj->getPrixtotal()));

        }
        $prixtotalAll = number_format($prixtotalAll);


        return $this->render('::BackendV2/proprietaire/files/portefeuille.html.twig', array('tauxreserv'=> $reservationConfirme,'reservation' => $pagination, 'prixtotaux' => $prixtotalAll, 'proprietaire'=>$user, 'pourcentagecommercial'=> $pourcentagecommercial));

    }


    public function  listeTypeChambreAction( Request $request,$iduser = null){
        $em = $this->getDoctrine()->getManager();
        $datatype = array();
        //On recupere l utilisateur en cours
        $userEncours = $this->container->get('security.context')->getToken()->getUser();
        if(!empty($iduser))
            $user = $em->getRepository('EmBackendBundle:User')->find($iduser);
        else
            $user = $userEncours;

        if(!$user || !$userEncours){
            throw new NotFoundHttpException(' Erreur : requete invalide !');
            //$request->getSession()->getFlashBag()->add('notice', 'Erreur reque invalide !');
            //envoie de mail a Afrikhotel
            //return $this->redirect($this->generateUrl('em_backend_homepage'));
        }
        //On recupere l'utilisateur en cours !
        if($user->getId() == $userEncours->getId() ){
            $user = $this->container->get('security.context')->getToken()->getUser();
        }elseif($this->get('security.context')->isGranted('ROLE_ADMIN')){
            $user = $em->getRepository('EmBackendBundle:User')->find($iduser);
        }else{
            //throw new NotFoundHttpException(' Accès interdit ! vous n\'avez pas les droits');
            $request->getSession()->getFlashBag()->add('notice', 'Accès interdit ! vous n\'avez pas les droits');
            //envoie de mail a Afrikhotel
            return $this->redirect($this->generateUrl('em_backend_homepage'));
        }

        $hoteleierslastvalide = $em->getRepository('EmBackendBundle:User')->findByRoleAndStatus('ROLE_PROPRIETAIRE', true);
        $agence = $em->getRepository('EmBackendBundle:Agences')->findOneBy(array('proprietaire' => $iduser));
        //Si Adfmin requete global sur les hotels
        // On vérifie que l'utilisateur dispose bien du rôle ROLE_AUTEUR

        if($this->get('security.context')->isGranted('ROLE_ADMIN')){

            $datatype['chambre-simple'] = $em->getRepository('EmBackendBundle:Chambre')->findOneBy(array('slugchambre' => 'chambre-simple'));
            $datatype['chambre-standard'] = $em->getRepository('EmBackendBundle:Chambre')->findOneBy(array('slugchambre' => 'chambre-standard'));
            $datatype['mini-suite'] = $em->getRepository('EmBackendBundle:Chambre')->findOneBy(array('slugchambre' => 'mini-suite'));
            $datatype['suite-junior'] = $em->getRepository('EmBackendBundle:Chambre')->findOneBy(array('slugchambre' => 'suite-junior'));
            $datatype['suite-senior'] = $em->getRepository('EmBackendBundle:Chambre')->findOneBy(array('slugchambre' => 'suite-senior'));
            $datatype['suite-executive'] = $em->getRepository('EmBackendBundle:Chambre')->findOneBy(array('slugchambre' => 'suite-executive'));

        }elseif($this->get('security.context')->isGranted('ROLE_PROPRIETAIRE')){
            //On recupere l utilisateur en cours


            //On recupere l agence

            $datatype['chambre-simple'] = $em->getRepository('EmBackendBundle:Chambre')->typeChambreBlock($agence, 'chambre-simple');

            $datatype['chambre-standard'] = $em->getRepository('EmBackendBundle:Chambre')->typeChambreBlock( $agence,  'chambre-standard');
            $datatype['mini-suite'] = $em->getRepository('EmBackendBundle:Chambre')->typeChambreBlock( $agence,  'mini-suite');
            $datatype['suite-junior'] = $em->getRepository('EmBackendBundle:Chambre')->typeChambreBlock( $agence, 'suite-junior');
            $datatype['suite-senior'] = $em->getRepository('EmBackendBundle:Chambre')->typeChambreBlock( $agence, 'suite-senior');
            $datatype['suite-executive'] = $em->getRepository('EmBackendBundle:Chambre')->typeChambreblock( $agence, 'suite-executive');
        }
        return $this->render('::BackendV2/renderTwig/listetypechambre.html.twig',array('datatype' =>  $datatype, 'users' => $user, 'agences'=>$agence, 'proprietaire'=>$this->getUser()) );

    }



    public function reservationDetailsAction( $idreservation = null)
    {
        $reservationid = $this->get('nzo_url_encryptor')->decrypt($idreservation) ;

        $em = $this->getDoctrine()->getManager();
        $datareservation = $em->getRepository('EmFrontendBundle:Reservations')->findOneBy(array('id' => $reservationid), array('id' => 'DESC'));
        $allreservation = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array('proprietaire' => $datareservation->getProprietaire()), array('id' => 'DESC'));

        return $this->render('::BackendV2/proprietaire/files/detailsreservations.html.twig', array('reservation' => $datareservation, 'allreservation' => $allreservation, 'proprietaire'=> $this->getUser()));
    }



    public function reservationConfirmerAction(Request $request ,$idreservation, $status){

        $reservationid = $this->get('nzo_url_encryptor')->decrypt($idreservation) ;
        if($this->get('security.context')->isGranted('ROLE_ADMIN') ||$this->get('security.context')->isGranted('ROLE_SUPERVISEUR')){

        }elseif($this->get('security.context')->isGranted('ROLE_PROPRIETAIRE')){
            if($status === 'valider'){
                $em = $this->getDoctrine()->getManager();
                $reservation = $em->getRepository('EmFrontendBundle:Reservations')->findOneBy(array('id' =>$reservationid));


                if(! $reservation){

                    throw new NotFoundHttpException('Le Système a rencontré une erreur contacter Homemobilite !');
                }
                if($status === 'valider'){
                    $reservation->setConfirmer(true);
                }
                $em->flush();
                $request->getSession()->getFlashBag()->add('Notice',  'Vous venez de '. $status.'  la reservation de '.$reservation->getPrenoms().' avec succès !');
                return $this->redirect($this->generateUrl('em_backend_proprietaire_reservationhistorique'));
            }
        }

        return $this->redirect($this->generateUrl('em_backend_proprietaire_reservationhistorique'));

    }

}
