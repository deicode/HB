<?php

namespace Em\BackendBundle\Controller;

use Em\BackendBundle\Entity\Agences;
use Em\BackendBundle\Entity\Bienimmo;
use Em\BackendBundle\Entity\Communes;
use Em\BackendBundle\Entity\Etatimmo;
use Em\BackendBundle\Entity\Informationsite;
use Em\BackendBundle\Entity\News;
use Em\BackendBundle\Entity\Pagesite;
use Em\BackendBundle\Entity\Pays;
use Em\BackendBundle\Entity\Pub;
use Em\BackendBundle\Entity\Slider;

use Em\BackendBundle\Entity\Statusimmo;
use Em\BackendBundle\Entity\Typeimmo;
use Em\BackendBundle\Entity\Typesaison;
use Em\BackendBundle\Entity\User;
use Em\BackendBundle\Entity\Villes;
use Em\BackendBundle\Form\Handler\BienimmoHandler;
use Em\BackendBundle\Form\Handler\EtatimmoHandler;
use Em\BackendBundle\Form\Handler\PaysHandler;
use Em\BackendBundle\Form\Handler\PubHandler;
use Em\BackendBundle\Form\Handler\StatusimmoHandler;
use Em\BackendBundle\Form\Handler\TypeimmoHandler;
use Em\BackendBundle\Form\Handler\TypesaisonHandler;
use Em\BackendBundle\Form\Type\BienimmoType;
use Em\BackendBundle\Form\Type\CommunesType;
use Em\BackendBundle\Form\Handler\CommunesHandler;
use Em\BackendBundle\Form\Handler\InformationsiteHandler;
use Em\BackendBundle\Form\Handler\NewsHandler;
use Em\BackendBundle\Form\Handler\PagesiteHandler;
use Em\BackendBundle\Form\Handler\SliderHandler;
use Em\BackendBundle\Form\Handler\UploadHandler;
use Em\BackendBundle\Form\Handler\VillesHandler;
use Em\BackendBundle\Form\Type\EtatimmoType;
use Em\BackendBundle\Form\Type\InformationsiteType;
use Em\BackendBundle\Form\Type\NewsType;
use Em\BackendBundle\Form\Type\PagesiteType;
use Em\BackendBundle\Form\Type\ParamType;
use Em\BackendBundle\Form\Type\PaysType;
use Em\BackendBundle\Form\Type\PubType;
use Em\BackendBundle\Form\Type\SliderType;
use Em\BackendBundle\Form\Type\StatusimmoType;
use Em\BackendBundle\Form\Type\TypeimmoType;
use Em\BackendBundle\Form\Type\TypesaisonType;
use Em\BackendBundle\Form\Type\UserType;
use Em\BackendBundle\Form\Type\VillesType;
use Em\FrontendBundle\Entity\Images;
use Em\FrontendBundle\Form\ImagesType;

use Em\FrontendBundle\Repository\ReservationsRepository;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BackendController extends Controller
{
    public function indexAction()
    {

        $em = $this->getDoctrine()->getManager();
        $hotelier = $em->getRepository('EmBackendBundle:Agences')->findAll();

        if($this->get('security.context')->isGranted('ROLE_SUPERVISEUR')){
            $datareservation = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array(), array('id' =>'DESC'));
        }elseif($this->isGranted('ROLE_PROPRIETAIRE') ){
            return $this->redirect($this->generateUrl('em_backend_proprietaire_homepage'));
        }
        else{
            $user = $this->container->get('security.context')->getToken()->getUser();
            $datareservation = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array('hotelier' => $user), array('id' =>'DESC'));

        }

        return $this->render('EmBackendBundle:Backend:file/index.html.twig',array('reservation' => $datareservation, 'hotelier' =>  $hotelier));
    }

    //Controller render venant de la view pour les menu

    //ROLE_ADMIN
    public function adminMenuLeftAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('::backend/blocks/admin/menuLeft.html.twig', array('user' => $user));
    }

    //ROLE_PROPRIETAIRE
    public function hotelierMenuLeftAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('::backend/blocks/hotelier/menuLeft.html.twig', array('user' => $user));

    }

    //ROLE_SUPERVISEUR
    public function superviseurMenuLeftAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('::backend/blocks/superviseur/menuLeft.html.twig', array('user' => $user));

    }
    //ROLE_ADMIN
    public function adminHeaderAction()
    {
              $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('::backend/blocks/admin/header.html.twig', array('user' => $user));

    }

    //ROLE_PROPRIETAIRE
    public function hotelierHeaderAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('::backend/blocks/hotelier/header.html.twig', array('user' => $user));

    }

    //ROLE_SUPERVISEUR
    public function superviseurHeaderAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('::backend/blocks/superviseur/header.html.twig', array('user' => $user));

    }

    //Block left panel

    public function adminLeftPanelAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('::backend/blocks/admin/leftpanel.html.twig', array('user' => $user));

    }

    public function superviseurLeftPanelAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('::backend/blocks/superviseur/leftpanel.html.twig', array('user' => $user));

    }

    public function hotelierLeftPanelAction()
    {
        $user = $this->container->get('security.context')->getToken()->getUser();
        return $this->render('::backend/blocks/hotelier/leftpanel.html.twig', array('user' => $user));

    }
    /*
     * functions slide
     */
    public function addSlideHomeAction(Request $request)
    {

        //Appel su service slide handler
        $formHandler = $this->get('slider_handler');
        //On lien du dossier d upload
        $lienDossier = '/../../../../../web/bundles/emfrontend/assets/uploads/images/slides';
        //appel de la class gestion des upload
        $em = $this->getDoctrine()->getManager();
        $uploadHandler = new UploadHandler($this->createForm(new SliderType(), new Slider()), $request, $em, $lienDossier);

        if ($formHandler->process()) {

            $dataImages = $uploadHandler->uploadImages('slider');

            if (!empty($dataImages)) {
                if ($formHandler->onSuccess($dataImages)) {
                    $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter un nouveau slide !');
                    return $this->redirect($this->generateUrl('em_backend_slidehome'));
                }
            } else {
                //On declenche une erreur lié a l'upload image
                throw $this->createNotFoundException(
                    'Error of sytème contact E-mitic Agency ! ');
            }

        }

        return $this->render('EmBackendBundle:Backend:file/addslidehome.html.twig', array('form' => $formHandler->getForm()->createView()));
    }
    public  function  enabledSlideHomeAction(Request $request ,Slider $slider, $action = null){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Slider')->findOneBy(array('id' => $slider->getId()));
        if(null == $entity){
            throw new NotFoundHttpException('Aucune informations existante');

        }

        if($action == 'oui'){
            $entity->setEnabled(true);
        }else{
            $entity->setEnabled(false);

        }
        $em->flush();
        $request->getSession()->getFlashBag()->add('notice', ' Action effectuée avec succès !');
        return $this->redirect($this->generateUrl('em_backend_slidehome'));

    }


    public function addPubAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //Appel su service slide handler
        $formHandler =  new PubHandler($this->createForm(new PubType(), new Pub()), $request, $em);
        //On lien du dossier d upload
        $lienDossier = '/../../../../../web/bundles/emfrontend/assets/uploads/images/pub';
        //appel de la class gestion des upload

        $uploadHandler = new UploadHandler($this->createForm(new PubType(), new Pub()), $request, $em, $lienDossier);

        if ($formHandler->process()) {

            $dataImages = $uploadHandler->uploadImages('pub');

            if (!empty($dataImages)) {
                if ($formHandler->onSuccess($dataImages)) {
                    $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter une pub !');
                    return $this->redirect($this->generateUrl('em_backend_addpub'));
                }
            } else {
                //On declenche une erreur lié a l'upload image
                $request->getSession()->getFlashBag()->add('notice', ' Error of sytème contact E-mitic Agency !');
                return $this->redirect($this->generateUrl('em_backend_addpub'));
            }

        }

        return $this->render('EmBackendBundle:Backend:file/addpub.html.twig', array('form' => $formHandler->getForm()->createView()));
    }

    public function listeSlideHomeAction()
    {

        $em = $this->getDoctrine()->getManager();
        $slider = $em->getRepository('EmBackendBundle:Slider')->findBy(array(), array('id' => 'DESC'));

        return $this->render('EmBackendBundle:Backend:file/listeslidehome.html.twig', array('entitSlider' => $slider));
    }

    /*
     *  Gestion des pages du site
     */
    public function listePageSiteAction()
    {
        $em = $this->getDoctrine()->getManager();
        $pagesite = $em->getRepository('EmBackendBundle:Pagesite')->findBy(array(), array('id' => 'DESC'));

        return $this->render('EmBackendBundle:Backend:file/listepagesite.html.twig',array('pagesite' => $pagesite));
    }


    public function createPagesiteAction(Request $request, $idpage = null)
    {
        //on declarre l'entity
        //Assurer vous d avoir definit les namespaces


        $em = $this->getDoctrine()->getManager();
        $pagesite = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("id"=> $idpage));

        $pagesiteHandler = new PagesiteHandler($this->createForm(new PagesiteType(), new Pagesite()), $request, $em);

        if($pagesite){

            $pagesiteHandler = new PagesiteHandler($this->createForm(new PagesiteType(), $pagesite), $request, $em);

            if ($pagesiteHandler->processupdate()) {

               if($pagesiteHandler->onSuccessupdate($pagesite)){
                   $request->getSession()->getFlashBag()->add('notice', ' Mise à jour effectuée  !');
                   return $this->redirect($this->generateUrl('em_backend_listepagesite'));
               }

            }

        }


        if ($pagesiteHandler->process()) {

            $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter une page !');
            return $this->redirect($this->generateUrl('em_backend_listepagesite'));
        }

        return $this->render('EmBackendBundle:Backend:file/createpagesite.html.twig', array('form' => $pagesiteHandler->getForm()->createView(), 'idpage' => $idpage));

    }


    /*
     * Gestion des news
     */
    public function listeNewsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('EmBackendBundle:News')->findBy(array(), array('id' => 'DESC'));


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $news,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );
      //  var_dump($news[0]->getImages());exit;
        return $this->render('EmBackendBundle:Backend:file/listenews.html.twig', array("pagination" => $pagination));
    }

    public function addNewsAction(Request $request, $idpage = null)
    {
        //on declarre l'entity
        //Assurer vous d avoir definit les namespaces


        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('EmBackendBundle:News')->find($idpage);

        $newsHandler = new NewsHandler($this->createForm(new NewsType(), new News($data = null)), $request, $em);

        $lienDossier = '/../../../../../web/bundles/emfrontend/assets/uploads/images/news';
        //appel de la class gestion des upload

        $uploadHandler = new UploadHandler($this->createForm(new NewsType(), new News($data = null)), $request, $em, $lienDossier);

        //Block pour Update de l entité News
        //On verifie si la requete n estpas vie
        if($news){

          // var_dump($news);exit;
            $newsHandler = new NewsHandler($this->createForm(new NewsType(), new News($news)), $request, $em);

            if ( $newsHandler->processupdate()) {

               $dataImages = $uploadHandler->uploadImages('news');
               if (!empty($dataImages)) {
                    /*
                     * new News($news)  on pass l entité news pour update
                     */
                    if ($newsHandler->onSuccessupdate($dataImages, $news)) {
                        $request->getSession()->getFlashBag()->add('notice', ' Mise à jour effectuée  !');

                        return $this->redirect($this->generateUrl('em_backend_listenews'));

                    }
                }
            }

        }
        //Fin script update

       //Script d'insertion
        if ( $newsHandler->process()) {

            $dataImages = $uploadHandler->uploadImages('news');

            if (!empty($dataImages)) {
                if ($newsHandler->onSuccess($dataImages)) {


                    $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter une page !');
                    return $this->redirect($this->generateUrl('em_backend_listenews'));

                }
            }
        }

        return $this->render('EmBackendBundle:Backend:file/addnews.html.twig', array('form' =>  $newsHandler->getForm()->createView(), 'idpage' => $idpage));

    }




    /*
     * Gestion des villes & Commune
     */
    public function listeVilleAction()
    {
        $em = $this->getDoctrine()->getManager();
        $villes = $em->getRepository('EmBackendBundle:Villes')->findBy(array(), array('id' => 'DESC'));

        return $this->render('EmBackendBundle:Backend:file/listeville.html.twig', array('villes' => $villes));
    }
    public function listeCommuneAction()
    {
        $em = $this->getDoctrine()->getManager();
        $communes = $em->getRepository('EmBackendBundle:Communes')->findBy(array(), array('id' => 'DESC'));

        return $this->render('EmBackendBundle:Backend:file/listecommune.html.twig', array('communes' => $communes));
    }
    public function addVilleAction(Request $request, $idpage = null)
    {

        $em = $this->getDoctrine()->getManager();
        $villes = $em->getRepository('EmBackendBundle:Villes')->find($idpage);

        $villesHandler = new VillesHandler($this->createForm(new VillesType(), new Villes()), $request, $em);

        if($villes){

            $villesHandler = new VillesHandler($this->createForm(new VillesType(), $villes), $request, $em);

            if ($villesHandler->processupdate()) {
                if($villesHandler->onSuccessupdate($villes)){
                    $request->getSession()->getFlashBag()->add('notice', ' Mise à jour effectuée  !');
                    return $this->redirect($this->generateUrl('em_backend_listeville'));
                }

            }

        }
            //on verifie si la ville existe deja


        if ($villesHandler->process()) {

            if($villesHandler->onSuccess()){
                $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter une ville !');
                return $this->redirect($this->generateUrl('em_backend_listeville'));
            }

        }
        return $this->render('EmBackendBundle:Backend:file/addville.html.twig',array('form' => $villesHandler->getForm()->createView(), 'idpage' => $idpage));
    }


    public function addCommuneAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
      //  $villes = $em->getRepository('EmBackendBundle:Villes')->find($idpage);

        $communesHandler = new CommunesHandler($this->createForm(new CommunesType(), new Communes()), $request, $em);



        if ($communesHandler->process()) {

            $request->getSession()->getFlashBag()->add('Notice', ' Vous venez d\'ajouter une commune !');
            return $this->redirect($this->generateUrl('em_backend_listecommune'));
        }
        return $this->render('EmBackendBundle:Backend:file/addcommune.html.twig',array('form' => $communesHandler->getForm()->createView()));
    }

    /*
     * Gesion des reservation
     */

    public function listeReservationAction()
    {
        return $this->render('EmBackendBundle:Backend:file/listereservations.html.twig');
    }
    public function reservationDetailsAction( $idreservation = null)
    {
        $reservationid = $this->get('nzo_url_encryptor')->decrypt($idreservation) ;

        $em = $this->getDoctrine()->getManager();
        $datareservation = $em->getRepository('EmFrontendBundle:Reservations')->findOneBy(array('id' => $reservationid), array('id' => 'DESC'));
        $allreservation = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array('proprietaire' => $datareservation->getProprietaire()), array('id' => 'DESC'));

        return $this->render('EmBackendBundle:Backend:file/detailsreservations.html.twig', array('reservation' => $datareservation, 'allreservation' => $allreservation));
    }

    public function  informationSiteAction(Request $request, $idinfo = null){

        //on declarre l'entity
        //Assurer vous d avoir definit les namespaces


        $em = $this->getDoctrine()->getManager();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array("id"=> $idinfo));

        $infositeHandler = new InformationsiteHandler($this->createForm(new InformationsiteType(), new Informationsite()), $request, $em);


        if($infosite){

            $infositeHandler  = new InformationsiteHandler($this->createForm(new InformationsiteType(), $infosite), $request, $em);

            if ($infositeHandler ->processupdate()) {

                $request->getSession()->getFlashBag()->add('Notice', ' Vous venez de modifier les informations !');
                return $this->redirect($this->generateUrl('em_backend_information'));
            }

        }


        if ($infositeHandler->process()) {

            $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter une information!');
            return $this->redirect($this->generateUrl('em_backend_information'));
        }

        return $this->render('EmBackendBundle:Backend:file/informationsite.html.twig', array('form' => $infositeHandler->getForm()->createView(), 'idinfo' => $idinfo));
    }



    public function  informationSiteAfficheAction(Request $request){

        //on declarre l'entity
        //Assurer vous d avoir definit les namespaces


        $em = $this->getDoctrine()->getManager();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));
        if(!$infosite){
            throw new NotFoundHttpException('Aucune informations existante');
        }

        return $this->render('EmBackendBundle:Backend:file/informationsiteaffiche.html.twig', array( 'infosite' => $infosite ));
    }

    public function  parametreAction(Request $request,  $iduser= null){

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
            return $this->redirect($this->generateUrl('em_backend_homepage'));

        }

        return $this->render('EmBackendBundle:Backend:file/parametre.html.twig',array('form' => $form->createView()));

    }

    public function addUserAdminAction(Request $request){

        $form = $this->createForm(new UserType());


        if($request->isMethod('POST')){
             $email = $_POST['user']['email'];
             $em = $this->getDoctrine()->getManager();
             $user = $em->getRepository('EmBackendBundle:User')->findOneByEmail($email);

            if(!$user){
                $request->getSession()->getFlashBag()->add('Notice', ' Désolé utilisateur inconnu  veuillez l\'enregistrer depuis le site ! ');
                return $this->redirect($this->generateUrl('em_backend_adduser_admin'));
            }

            $entity =  new User($user);

            if($_POST['user']['roles'] == 'Admin'){
                $entity->setRoles(array('ROLE_ADMIN'));
            }elseif($_POST['user']['roles'] == 'Superviseur'){
                $entity->setRoles(array('ROLE_SUPERVISEUR'));
            }

            $em->flush();
            $request->getSession()->getFlashBag()->add('Notice', 'Parfait ! un nouveau membre à été ajouté a AfrikmonCl!');
            return $this->redirect($this->generateUrl('em_backend_admin_liste'));

        }

        return $this->render('EmBackendBundle:Backend:file/adduseradmin.html.twig',array('form' => $form->createView()));

    }

    public function  listeUserAdminAction(){

        $em = $this->getDoctrine()->getManager();
         $alluser = array();
        $alluser['alladmin'] = $em->getRepository('EmBackendBundle:User')->findRoleUserAdmin('ROLE_ADMIN');
         $alluser['allsuperviseur'] = $em->getRepository('EmBackendBundle:User')->findRoleUserAdmin('ROLE_SUPERVISEUR');
        return $this->render('EmBackendBundle:Backend:file/listeuseradmin.html.twig',array('allusers' =>  $alluser ));

    }



    public function monCoffreRootAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $reservationConfirme = $em->getRepository('EmFrontendBundle:Reservations')->findBy(array('confirmer' => true));
       $prixtotalAll = 0;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $reservationConfirme,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );

          foreach($reservationConfirme as $obj){
              $prixtotalAll += $obj->getPrixtotal() ;
              $obj->setPrixtotal(number_format($obj->getPrixtotal()));

          }
        $prixtotalAll = number_format($prixtotalAll);
        return $this->render('EmBackendBundle:Backend:file/moncoffreroot.html.twig', array('reservation' =>  $pagination, 'prixtotal' => $prixtotalAll));

    }

    public function monCoffreProprietaireAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $reservationConfirme = $em->getRepository('EmFrontendBundle:Reservations')->findReservationBYHotelier($user);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $reservationConfirme,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );
        $prixtotalAll = 0;
        foreach($reservationConfirme as $obj){
            $prixtotalAll += $obj->getPrixtotal() ;
            $obj->setPrixtotal(number_format($obj->getPrixtotal()));

        }
        $prixtotalAll = number_format($prixtotalAll);
        return $this->render('EmBackendBundle:Backend:file/moncoffrehotelier.html.twig', array('reservation' => $pagination, 'prixtotal' => $prixtotalAll));

    }


    public function reservationConfirmerAction(Request $request ,$idreservation, $status){

        $reservationid = $this->get('nzo_url_encryptor')->decrypt($idreservation) ;
        if($this->get('security.context')->isGranted('ROLE_ADMIN') ||$this->get('security.context')->isGranted('ROLE_SUPERVISEUR')){

        }elseif($this->get('security.context')->isGranted('ROLE_PROPRIETAIRE')){
            if($status === 'valider'){
                $em = $this->getDoctrine()->getManager();
                $reservation = $em->getRepository('EmFrontendBundle:Reservations')->findOneBy(array('id' =>$reservationid));


                if(! $reservation){

                    throw new NotFoundHttpException('Le Système a rencontré une erreur contacter Agence E-mitic !');
                }
                if($status === 'valider'){
                    $reservation->setConfirmer(true);
                }
                $em->flush();
                $request->getSession()->getFlashBag()->add('Notice',  'Vous venez de '. $status.'  la reservation de '.$reservation->getPrenoms().' avec succès !');
                return $this->redirect($this->generateUrl('em_backend_homepage'));
            }
        }

        return $this->redirect($this->generateUrl('em_backend_homepage'));

    }
    /*
     * liste page de connexin hotelier
     */

    public function renderConnexionHotelierAction(){

        $em = $this->getDoctrine()->getManager();
        $texte = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("titre"=> 'Connexion Hotelier'));


        return $this->render('EmBackendBundle:Security:loginText.html.twig', array( 'texte' => $texte));

    }

    public function renderEnregistrementHotelierAction(){

        $em = $this->getDoctrine()->getManager();
        $texte = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("titre"=> 'Enregistrement Hotelier'));


        return $this->render('EmBackendBundle:Registration:enregistrementText.html.twig', array( 'texte' => $texte));

    }

    public function renderListePubAction(){

        $em = $this->getDoctrine()->getManager();
        $dataentity = $em->getRepository('EmBackendBundle:Pub')->findBy(array(), array('id' => 'DESC'));


        return $this->render('EmBackendBundle:Backend:twigrender/listepub.html.twig', array( 'dataentity' => $dataentity));

    }

    /*
     * Liste des commentaire
     */
    public function avisUtilisateurAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $commentaire  = $em->getRepository('EmBackendBundle:Commentaire')->findBy(array(), array('id' => 'DESC'));
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $commentaire,
            $request->query->get('tracker', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('EmBackendBundle:Backend:twigrender/avisutilisateur.html.twig',array('pagination' => $pagination));
    }

    public function listeCommentairesAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $commentaire  = $em->getRepository('EmBackendBundle:Commentaire')->findBy(array(), array('id' => 'DESC'));
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $commentaire,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('EmBackendBundle:Backend:file/listecommentaire.html.twig', array('pagination' => $pagination));

    }

    public function enabledAction(Request $request ,$idcom, $status){


        if($status === 'valider' || $status === 'suspendre' || $status === 'activer'){
            $em = $this->getDoctrine()->getManager();
            $commentaire = $em->getRepository('EmBackendBundle:Commentaire')->find($idcom);
            if(!$commentaire){

                throw new NotFoundHttpException('Le Système a rencontré une erreur contacter Agence E-mitic !');
            }
            if($status === 'valider'){
                $commentaire->setEnabled(true);
            }elseif($status === 'suspendre'){
                $commentaire->setEnabled(false);
            }elseif($status === 'activer'){
            $commentaire->setEnabledHome(true);
            }

            $em->flush();
            $request->getSession()->getFlashBag()->add('Notice',  "Vous venez de $status  un commentaire avec succès !");
            return $this->redirect($this->generateUrl('em_backend_homepage'));
        }
        return $this->redirect($this->generateUrl('em_backend_homepage'));

    }





    //Fonction recherche code reservation

    public function searchReservationAction(Request $request, $code)
    {
        $em = $this->getDoctrine()->getManager();



        $codereserv = $em->getRepository('EmFrontendBundle:Reservations')->findByCode($code);

        if (empty($codereserv)) {
            $num = null;

        } else {
            $num = $codereserv;

            if($request->isMethod('POST')){
                $entity = $em->getRepository('EmFrontendBundle:Reservations')->findOneBy(array('numeroreservation' => $_POST['codereservation']));

                return $this->redirect($this->generateUrl('em_backend_reservations_details', array('idreservation' => $this->get('nzo_url_encryptor')->encrypt($entity->getId()))));
            }
        }

        $response = new JsonResponse();
        return  $response->setData(array('codereserv' => $num));

    }

    public function searchFormAction(Request $request){

        return $this->render('EmBackendBundle:Backend:twigrender/searchform.html.twig');
    }

    public function dataNewsletterAction(){

        //Speciale code E-mitic export csv

        $em = $this->getDoctrine()->getManager();
        $datacontact = $em->getRepository('EmBackendBundle:user')->findBy(array(), array('id'=> 'DESC'));

        $myFile = "../src/Em/BackendBundle/Resources/views/Backend/newsletter/contact.csv.twig";
        $fileO = fopen($myFile, 'w') or die("Impossible d' Ouvrir le fichier ");


        foreach($datacontact as $datas => $key){

            $stringData = $key->getEmail()."\n";

            fwrite($fileO, $stringData);

        }

        fclose($fileO);

        $response =$this->render('EmBackendBundle:Backend:newsletter/contact.csv.twig');

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="newsletter-contact.csv"');

        return $response;


    }


    public function addPaysAction(Request $request, $idpage = null)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Pays')->find($idpage);

        $Handler = new PaysHandler($this->createForm(new PaysType(), new Pays()), $request, $em);

        if($entity){

            $Handler = new PaysHandler($this->createForm(new PaysType(),  $entity), $request, $em);

            if ($Handler->processupdate()) {
                if($Handler->onSuccessupdate($entity)){
                    $request->getSession()->getFlashBag()->add('notice', ' Mise à jour effectuée  !');
                    return $this->redirect($this->generateUrl('em_backend_listepays'));
                }

            }

        }
        //on verifie si la ville existe deja


        if ($Handler->process()) {
            if($Handler->onSuccess()){
                $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter un pays !');
                return $this->redirect($this->generateUrl('em_backend_listepays'));
            }

        }
        return $this->render('EmBackendBundle:Backend:file/addpays.html.twig',array('form' => $Handler->getForm()->createView(), 'idpage' => $idpage));
    }


    public function addEtatimmoAction(Request $request, $idpage = null)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Etatimmo')->find($idpage);

        $Handler = new EtatimmoHandler($this->createForm(new EtatimmoType(), new Etatimmo()), $request, $em);

        if($entity){

            $Handler = new EtatimmoHandler($this->createForm(new EtatimmoType(),  $entity), $request, $em);

            if ($Handler->processupdate()) {
                if($Handler->onSuccessupdate($entity)){
                    $request->getSession()->getFlashBag()->add('notice', ' Mise à jour effectuée  !');
                    return $this->redirect($this->generateUrl('em_backend_listeetatimmo'));
                }

            }

        }
        //on verifie si la ville existe deja


        if ($Handler->process()) {
            if($Handler->onSuccess()){
                $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter un pays !');
                return $this->redirect($this->generateUrl('em_backend_listeetatimmo'));
            }

        }
        return $this->render('EmBackendBundle:Backend:file/addetatimmo.html.twig',array('form' => $Handler->getForm()->createView(), 'idpage' => $idpage));
    }



    public function addStatusimmoAction(Request $request, $idpage = null)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Statusimmo')->find($idpage);

        $Handler = new StatusimmoHandler($this->createForm(new StatusimmoType(), new Statusimmo()), $request, $em);

        if($entity){

            $Handler = new StatusimmoHandler($this->createForm(new StatusimmoType(),  $entity), $request, $em);

            if ($Handler->processupdate()) {
                if($Handler->onSuccessupdate($entity)){
                    $request->getSession()->getFlashBag()->add('notice', ' Mise à jour effectuée  !');
                    return $this->redirect($this->generateUrl('em_backend_listestatusimmo'));
                }

            }

        }
        //on verifie si la ville existe deja


        if ($Handler->process()) {
            if($Handler->onSuccess()){
                $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter un pays !');
                return $this->redirect($this->generateUrl('em_backend_listestatusimmo'));
            }

        }
        return $this->render('EmBackendBundle:Backend:file/addstatusimmo.html.twig',array('form' => $Handler->getForm()->createView(), 'idpage' => $idpage));
    }

    public function addTypeimmoAction(Request $request, $idpage = null)
    {

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Typeimmo')->find($idpage);

        $Handler = new TypeimmoHandler($this->createForm(new TypeimmoType(), new Typeimmo()), $request, $em);


        $lienDossier = '/../../../../../web/bundles/emfrontend/assets/uploads/images/Typeimmo';
        //appel de la class gestion des upload

        $uploadHandler = new UploadHandler($this->createForm(new NewsType(), new News($data = null)), $request, $em, $lienDossier);


        if($entity){

            $Handler = new TypeimmoHandler($this->createForm(new TypeimmoType(),  $entity), $request, $em);

            if ($Handler->processupdate()) {

                $dataImages = $uploadHandler->uploadImages('em_backendbundle_typeimmo');


                if($Handler->onSuccessupdate($dataImages,$entity)){
                    $request->getSession()->getFlashBag()->add('notice', ' Mise à jour effectuée  !');
                    return $this->redirect($this->generateUrl('em_backend_listetypeimmo'));
                }

            }

        }

        if ($Handler->process()) {

            $dataImages = $uploadHandler->uploadImages('em_backendbundle_typeimmo');
            if (!empty($dataImages)) {
                if ($Handler->onSuccess($dataImages)) {
                    $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter un Type immobilier !');
                    return $this->redirect($this->generateUrl('em_backend_listetypeimmo'));
                }
            }

        }
        return $this->render('EmBackendBundle:Backend:file/addtypeimmo.html.twig',array('form' => $Handler->getForm()->createView(), 'idpage' => $idpage));
    }

    public function addTypesaisonAction(Request $request)
    {
       // $idpage =1;
        $em = $this->getDoctrine()->getManager();
        $entity = null ;//$em->getRepository('EmBackendBundle:Typesaison')->find($idpage);

        $Handler = new TypesaisonHandler($this->createForm(new TypesaisonType(), new Typesaison()), $request, $em);

        if($entity){

            $Handler = new TypesaisonHandler($this->createForm(new TypesaisonType(), $entity), $request, $em);

            if ($Handler->processupdate()) {

                if($Handler->onSuccessupdate($entity)){
                    $request->getSession()->getFlashBag()->add('notice', ' Mise à jour effectuée  !');
                    return $this->redirect($this->generateUrl('em_backend_addtypesaison'));
                }

            }

        }

        if ($Handler->process()) {

                if ($Handler->onSuccess()) {
                    $request->getSession()->getFlashBag()->add('notice', ' Vous venez d\'ajouter un Type saisonnier !');
                    return $this->redirect($this->generateUrl('em_backend_addtypesaison'));
                }

        }
        return $this->render('EmBackendBundle:Backend:file/addtypesaison.html.twig',array('form' => $Handler->getForm()->createView()));
    }


    public function  addBienimmoAction(Request $request){

        //Appel su service slide handler
        //On lien du dossier d upload
        $lienDossier = '/../../../../../web/bundles/emfrontend/assets/pics/immobilier/';

        //appel de la class gestion des upload
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();

        $Handler = new BienimmoHandler($this->createForm(new BienimmoType(), new Bienimmo()), $request, $em);

        $uploadHandler = new UploadHandler($this->createForm(new BienimmoType(), new Bienimmo()),  $request, $em, $lienDossier);

        if ( $Handler->process()){


           // $dataImages = $uploadHandler->uploadImages('em_backendbundle_bienimmo');
            $entity =  $Handler->onSuccess();
                if ($entity) {
                    if ($uploadHandler->uploadMultipleImagesimmo($lienDossier, $entity)) {
                        $request->getSession()->getFlashBag()->add('notice', ' Votre Type de Chambre  est en cours d\' examen !');

                        return $this->redirect($this->generateUrl('em_backend_homepage'));
                    }
                }
              else {
                //On declenche une erreur lié a l'upload image
                throw $this->createNotFoundException(
                    'Error of système contact E-mitic Agency ! ');
            }

        }
        return $this->render('EmBackendBundle:Backend:file/addbienimmo.html.twig',array('form' => $Handler->getForm()->createView()));

    }

    public function  updateBienimmoAction(Request $request, Bienimmo $idpage = null){


        $em = $this->getDoctrine()->getManager();

        if(null == $idpage){
            throw new NotFoundHttpException('erreur système');
        }

        $Handler = $this->createForm(new BienimmoType(),$idpage);


        if ($request->getMethod() == 'POST') {

            $Handler->handleRequest($request);

            if ($Handler->isValid()) {

                $em->flush();
                $request->getSession()->getFlashBag()->add('Notice', ' Mise à jour  ,effectuée avec succès!');

                return $this->redirect($this->generateUrl('em_backend_listebienimmo'));


            }
        }

        return $this->render('EmBackendBundle:Backend:file/updatebienimmo.html.twig',array('form' => $Handler->createView(), 'bienimmo' => $idpage));

    }

    public function listePaysAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Pays')->findBy(array(), array('id' => 'DESC'));

        return $this->render('EmBackendBundle:Backend:file/listepays.html.twig', array('entity' => $entity));
    }
    public function listeEtatimmoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Etatimmo')->findBy(array(), array('id' => 'DESC'));

        return $this->render('EmBackendBundle:Backend:file/listeetatimmo.html.twig', array('entity' => $entity));
    }

    public function listeStatusimmoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Statusimmo')->findBy(array(), array('id' => 'DESC'));

        return $this->render('EmBackendBundle:Backend:file/listestatusimmo.html.twig', array('entity' => $entity));
    }


    public function listeTypeimmoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array(), array('id' => 'DESC'));

        return $this->render('EmBackendBundle:Backend:file/listetypeimmo.html.twig', array('entity' => $entity));
    }

    public function listeBienimmoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Bienimmo')->findBy(array(), array('id' => 'DESC'));
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entity,
            $request->query->get('tracker', 1)/*page number*/,
            15/*limit per page*/
        );
        return $this->render('EmBackendBundle:Backend:file/listebienimmo.html.twig', array('entity' => $pagination));
    }


    public function  newsBienImmoAction(){

        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Bienimmo')->findBy(array('locked' => true));
        return $this->render('EmBackendBundle:Backend:twigrender/newsbienimmo.html.twig', array('bienimmo' => $entity) );

    }


    public function listeSingleBienimmoAction(Request $request , Bienimmo $id = null){

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('EmBackendBundle:Bienimmo')->find($id);
        //On verifie l entite
        if(!$entity){

            throw new NotFoundHttpException('Désolé error 404 !');
        }
        if($entity->getId() == null){

            $request->getSession()->getFlashBag()->add('Notice', ' Oups error');
            //envoie de mail
            return $this->redirect($this->generateUrl('em_backend_listehoteliers'));

        }

        $images = $em->getRepository('EmBackendBundle:Imagesmultipleimmo')->findBy(array('bienimmo' => $entity), array('id' => 'DESC'));

        return $this->render('EmBackendBundle:Backend:file/listesinglebienimmo.html.twig', array('entity' => $entity, 'images' =>  $images));

    }




    public function enabledBienimmoAction(Request $request ,$idbienimmo, $status){

        if($status === 'valider' || $status === 'suspendre'){
            $em = $this->getDoctrine()->getManager();
            $agence = $em->getRepository('EmBackendBundle:Bienimmo')->find($idbienimmo);
            if(!$agence){

                throw new NotFoundHttpException('Le Système a rencontré une erreur !');
            }
            if($status === 'valider'){
                $agence->setLocked(false);
            }elseif($status === 'suspendre'){
                $agence->setLocked(true);
            }

            $em->flush();
            $request->getSession()->getFlashBag()->add('Notice',  "Vous venez de $status  une propriété immobilière avec succès !");
        }
        return $this->redirect($this->generateUrl('em_backend_homepage'));

    }
}