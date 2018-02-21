<?php

namespace Em\FrontendBundle\Controller;

use Em\BackendBundle\Api\CinetPay;
use Em\BackendBundle\Entity\Agences;
use Em\BackendBundle\Entity\Bienimmo;

use Em\BackendBundle\Entity\Chambre;
use Em\BackendBundle\Entity\Communes;
use Em\BackendBundle\Entity\News;
use Em\BackendBundle\Entity\Pays;
use Em\BackendBundle\Entity\Slider;
use Em\BackendBundle\Form\Handler\BienimmoHandler;
use Em\BackendBundle\Form\Handler\CommentaireHandler;
use Em\BackendBundle\Form\Handler\UploadHandler;
use Em\BackendBundle\Form\Type\BienimmoType;

use Em\BackendBundle\Form\Type\CommunesType;
use Em\BackendBundle\Form\Type\ParamType;
use Em\BackendBundle\Entity\User;
use Em\FrontendBundle\Entity\Allfonction;

use Em\FrontendBundle\Entity\Commande;
use Em\FrontendBundle\Entity\Contact;
use Em\FrontendBundle\Entity\Reservations;
use Em\FrontendBundle\Form\ContactType;
use Em\FrontendBundle\Form\Handler\ReservationsHandler;
use Em\FrontendBundle\Form\HotelRechercheType;
use Em\FrontendBundle\Form\ReservationsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Validator\Constraints\DateTime;


class FrontendController extends Controller
{

    /*
     * Page home
     */
    public function indexAction()
    {
        $slug = 'home';
        $em = $this->getDoctrine()->getManager();
        $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array('publish' => true),array('libelle' => 'DESC'));
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));
        $locataire = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("id" => 5));
        $proprietaire = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("id" => 6));

        return $this->render('EmFrontendBundle:Layouts:index.html.twig', array('typeimmo'=>$type,
            'informations'=> $infosite, 'locataire'=>$locataire, 'proprietaire' =>$proprietaire, 'slug'=>$slug));
    }


    public function renderListeTypeImmoAction(){
        $em = $this->getDoctrine()->getManager();
        $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array('publish' => true),array('libelle' => 'DESC'));
        return $this->render('EmFrontendBundle:renderTwig:renderlistetypeimmo.html.twig', array('typeimmo'=>$type));
    }

    public function proprietaireAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("id" => 6));


        return $this->render('EmFrontendBundle:files:proprietaire.html.twig',
            array("entity" => $dataentity));
    }

    public function locataireAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("id" => 5));


        return $this->render('EmFrontendBundle:files:locataire.html.twig', array("entity" => $dataentity));
    }


    public function basicPageAction( $slug = null)
    {
        $em = $this->getDoctrine()->getManager();
        $ref = $slug;
        $dataentity = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("slug" => $slug));
        if(!$dataentity){

            throw new NotFoundHttpException('error 404 page not Found');
        }
        return $this->render('EmFrontendBundle:files:basicpage.html.twig',
            array("entity" => $dataentity, 'slug'=>$ref));
    }

    public function pageStatiqueAction( $slug = null)
    {
        $em = $this->getDoctrine()->getManager();
        $ref = $slug;
        $dataentity = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("slug" => $slug));
        if(!$dataentity){

            throw new NotFoundHttpException('error 404 page not Found');
        }
        return $this->render('EmFrontendBundle:files:pagestatique.html.twig',
            array("entity" => $dataentity, 'slug'=>$ref));
    }

    public function PolitiqueAction( $slugs = null)
    {
        $em = $this->getDoctrine()->getManager();
        $ref = 'qui-sommes-nous';
        $dataentity = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("slug" => $slugs));
        if(!$dataentity){

            throw new NotFoundHttpException('error 404 page not Found');
        }
        return $this->render('EmFrontendBundle:files:politique.html.twig',
            array("entity" => $dataentity, 'slug'=>$ref));
    }

    public function conditionsGeneralesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("slug" => "conditions-generales"));
        // var_dump($dataentity);exit;
        return $this->render('EmFrontendBundle:Layouts:conditiongenerale.html.twig', array("dataentity" => $dataentity));
    }

    public function politiqueConfidentialiteAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("slug" => "politique-confidentialite"));
        // var_dump($dataentity);exit;
        return $this->render('EmFrontendBundle:Layouts:politiqueconfidentialite.html.twig', array("dataentity" => $dataentity));
    }
    public function commentMarcheAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("slug" => "comment-a-marche"));
        // var_dump($dataentity);exit;
        return $this->render('EmFrontendBundle:Layouts:commentmarche.html.twig', array("dataentity" => $dataentity));
    }
    /*
     * Controller contact du site
     */

    public function contactAction(Request $request)
    {

        $slug ='contact';
        $em = $this->getDoctrine()->getManager();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));
        $textcontact = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("title" => "Contact"));



        $contact = new Contact();


        $form = $this->get('form.factory')->create(new ContactType(),$contact);

        //On affecte les donnees POST aux variables du formulaire contact
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            // Création de l'e-mail : le service mailer utilise SwiftMailer, donc nous créons une instance de Swift_Message
            $message = \Swift_Message::newInstance()

                ->setSubject($contact->getNomPrenoms())
                ->setFrom('no-reply@immoonline.com')
                ->setTo($infosite->getEmail())
                ->setBody($contact->getMessage().' <br> Email : '.$contact->getEmail());

            // Retour au service mailer, nous utilisons sa méthode « send() » pour envoyer notre $message
            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('Notice', 'Email envoyé avec succès l\'equipe ImmoOnline vous dit Merci !.');
           return $this->redirect($this->generateUrl('em_frontend_contact'));
        }

        return $this->render('EmFrontendBundle:files:contact.html.twig',
            array('form' => $form->createView(), 'slug'=>$slug,'informations' => $infosite, 'textcontact' => $textcontact));
    }


    /*
     * Render Contact
     */

    public function renderContactAction(Request $request, $entity,  $reference = null)
    {

        $slug = 'contact';
        $em = $this->getDoctrine()->getManager();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));
        $textcontact = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("title" => "Contact"));



        $contact = new Contact();

       if(null !=$reference){
                               $contact->setMessage('Bonjour, Je souhaiterais avoir plus d\'informations sur le bien de reférence '.$reference.' Pourriez-vous me recontacter svp ?
                    Cordialement,');
       }else{
           $contact->setMessage('Bonjour, Je souhaiterais avoir une reservation à l\'hôtel '.$entity.' Pourriez-vous me recontacter svp ?
                    Cordialement,');
       }
        $form = $this->get('form.factory')->create(new ContactType(),$contact);

        //On affecte les donnees POST aux variables du formulaire contact
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($contact);
            $em->flush();
            // Création de l'e-mail : le service mailer utilise SwiftMailer, donc nous créons une instance de Swift_Message
            $message = \Swift_Message::newInstance()

                ->setSubject($contact->getNomPrenoms())
                ->setFrom('no-reply@immoonline.com')
                ->setTo($infosite->getEmail())
                ->setBody($contact->getMessage().' <br> Email : '.$contact->getEmail());

            // Retour au service mailer, nous utilisons sa méthode « send() » pour envoyer notre $message
            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('Notice', 'Email envoyé avec succès l\'equipe ImmoOnline vous sera de retour dans peu !.');
            return $this->redirect($this->generateUrl('em_frontend_contact'));
        }

        return $this->render('EmFrontendBundle:renderTwig:rendercontact.html.twig',
            array('form' => $form->createView(), 'slug'=>$slug,'informations' => $infosite, 'textcontact' => $textcontact));
    }

    /*
     * Render Contact
     */

    public function renderReservationAction(Request $request, $entity,  $reference = null)
    {

        $slug = 'contact';
        $em = $this->getDoctrine()->getManager();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));
        $textcontact = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("title" => "Contact"));

        $reservation = new Reservations();

        if($this->get('security.context')->isgranted('ROLE_USER')){
            $user = $this->get('security.context')->getToken()->getUser();
            $reservation->setNom($user->getNom());
            $reservation->setPrenoms($user->getUsername());
            $reservation->setPhone($user->getPhone());
            $reservation->setEmail($user->getEmail());

            $form = $this->createForm(new ReservationsType(), $reservation);
        }else{
            $form = $this->createForm(new ReservationsType(), new Reservations());
        }

        //On affecte les donnees POST aux variables du formulaire contact
        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            //rechercher si l'utilisateur existe
            var_dump($reservation);die();
            $em = $this->getDoctrine()->getManager();
            $em->persist($reservation);
            $em->flush();
            // Création de l'e-mail : le service mailer utilise SwiftMailer, donc nous créons une instance de Swift_Message
            $message = \Swift_Message::newInstance()

                ->setSubject($contact->getNomPrenoms())
                ->setFrom('no-reply@immoonline.com')
                ->setTo($infosite->getEmail())
                ->setBody($reservation->getMessage().' <br> Email : '.$reservation->getEmail());

            // Retour au service mailer, nous utilisons sa méthode « send() » pour envoyer notre $message
            $this->get('mailer')->send($message);

            $request->getSession()->getFlashBag()->add('Notice', 'Email envoyé avec succès l\'equipe ImmoOnline vous sera de retour dans peu !.');
            return $this->redirect($this->generateUrl('em_frontend_homepage'));
        }

        return $this->render('EmFrontendBundle:renderTwig:renderreservation.html.twig',
            array('form' => $form->createView(), 'slug'=>$slug,'informations' => $infosite, 'textcontact' => $textcontact));
    }


    /*
     * liste des hotels par niveau d'etoile
     */

    public function hotelEtoileAction()
    {

        return $this->render('EmFrontendBundle:Layouts:hoteletoile.html.twig');
    }

    /*
     * Details , caracteristique de l'hotel
     */
    public function detailscaracteristiqueHotelsAction(  Agences $idagence = null)
    {

        $em =$this->getDoctrine()->getManager();



        $dataagence = $em->getRepository('EmBackendBundle:Agences')->findOneBy(array('id' => $idagence->getId()));
       // var_dump($dataagence);exit;
        // on recupere toutes les communes

        if(!$dataagence){

          throw new NotFoundHttpException('error');
        }

        $dataagencechambre = $em->getRepository('EmBackendBundle:Chambre')->recupAgenceChambre($dataagence);

    //   var_dump($dataagencechambre[0]);exit;

        if(isset($dataagencechambre[0])){
            $dataagencechambresingle = $dataagencechambre[0];
        }else{
            throw new NotFoundHttpException('Désolé Cette Agence na pas de chambres disponibles ! ');

        }
        $dataallrooms = $em->getRepository('EmBackendBundle:Chambre')->recupAgenceAllChambre($dataagence);
        $imagesentity = $em->getRepository('EmBackendBundle:Imagesmultiple')->findBy(array('agence' => $dataagence));

        return $this->render('EmFrontendBundle:files:detailhotels.html.twig',
            array('datasincerooms' => $dataagencechambresingle,
            'dataimages' => $imagesentity , 'dataallroom' => $dataallrooms ,
            ));
    }


    /*
     * function des blocks de la page home
     */


    public function  searchHomeAction(){

        return $this->render('::frontend/blocks/search.html.twig');

    }

    public function  listeHotelsEtoilesHomeAction(){
        $em = $this->getDoctrine()->getManager();

        $dataentity['5'] = $em->getRepository('EmBackendBundle:Agences')->reupAgenceGrade(5);
        $dataentity['4'] = $em->getRepository('EmBackendBundle:Agences')->reupAgenceGrade(4);

        $dataentity['3'] = $em->getRepository('EmBackendBundle:Agences')->reupAgenceGrade(3);

        $dataentity['2'] = $em->getRepository('EmBackendBundle:Agences')->reupAgenceGrade(2);

        $dataentity['1'] = $em->getRepository('EmBackendBundle:Agences')->reupAgenceGrade(1);

        return $this->render('::frontend/blocks/listehotelsEtoilebyagences.html.twig', array('dataentity' => $dataentity));



    }

    public function pubDernierDealHomeAction() {

        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Pub')->pubActif();
        return $this->render('::frontend/blocks/pubDernierDeal.html.twig', array('dataentity' => $dataentity));
    }

    public function  principaleVilleHomeAction(){
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Villes')->reupHomeville();

        return $this->render('::frontend/blocks/blockHomelisteVille.html.twig',array('dataentity' => $dataentity));
    }

    public function blocktextHomeAction(){
        $em =$this->getDoctrine()->getManager();

        $datablocks = $em->getRepository('EmBackendBundle:Pagesite')->findBy(array("title" => "Accueil"), array('id' => 'DESC'));
        return $this->render('::frontend/blocks/blocktextHome.html.twig',array('blocks' => $datablocks));

    }

    public function newslisteAction(Request $request)
    {
        $slug = 'news-liste';
        $em = $this->getDoctrine()->getManager();
        $newsliste = $em->getRepository('EmBackendBundle:News')->findBy(array(), array('id' => 'DESC'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $newsliste,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('EmFrontendBundle:files:newsliste.html.twig',
            array('pagination' => $pagination, 'news' =>$newsliste, 'slug'=>$slug));
    }

    public function newsAction(News $id = null,  $slug =null)
    {

        $em = $this->getDoctrine()->getManager();
        $news = $em->getRepository('EmBackendBundle:News')->findOneBy(array('id' => $id->getId()));
        $newsliste = $em->getRepository('EmBackendBundle:News')->findBy(array(), array('id' => 'DESC'));
        if(!$news){
            throw new NotFoundHttpException('Le système error 404');
        }
        return $this->render('EmFrontendBundle:files:news.html.twig', array('datanews' =>$news, 'news' =>$newsliste, 'slug'=> $slug));
    }
    public function footerAction(){

        $em = $this->getDoctrine()->getManager();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));
        $pays    = $em->getRepository('EmBackendBundle:Pays')->findBy(array(),array('libelle' => 'DESC'));
        $status  =    $em->getRepository('EmBackendBundle:Statusimmo')->findBy(array(),array('libelle' => 'DESC'));
        $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array(),array('libelle' => 'DESC'));
        $ville    = $em->getRepository('EmBackendBundle:Villes')->findBy(array(),array('nom' => 'DESC'));

        return $this->render('::frontend/blocks/footer.html.twig',array('informations' => $infosite,
         'pays' => $pays,
         'status' => $status,
          'type' => $type,
           'ville' => $ville
        ));

    }

    public function footerPageAction(){
        $em = $this->getDoctrine()->getManager();

        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));
        $pays    = $em->getRepository('EmBackendBundle:Pays')->findBy(array(),array('libelle' => 'DESC'));
        $status  =    $em->getRepository('EmBackendBundle:Statusimmo')->findBy(array(),array('libelle' => 'DESC'));
        $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array(),array('libelle' => 'DESC'));
        $ville    = $em->getRepository('EmBackendBundle:Villes')->findBy(array(),array('nom' => 'DESC'));

        return $this->render('::frontend/blocks/footerpage.html.twig',array('informations' => $infosite,
            'pays' => $pays,
            'status' => $status,
            'type' => $type,
            'ville' => $ville
        ));
    }

    public function headPageAction(){

        $em = $this->getDoctrine()->getManager();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));
        $pays    = $em->getRepository('EmBackendBundle:Pays')->findBy(array(),array('libelle' => 'DESC'));
        /* if(!$infosite){
             throw new NotFoundHttpException('Aucune informations existante');

         }*/
        return $this->render('::frontend/blocks/headpage.html.twig',array('informations' => $infosite, 'pays' => $pays));

    }

    public function menuPageRightAction(){

        $em = $this->getDoctrine()->getManager();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));
        $pays    = $em->getRepository('EmBackendBundle:Pays')->findBy(array(),array('libelle' => 'DESC'));
        $status  =    $em->getRepository('EmBackendBundle:Statusimmo')->findBy(array(),array('libelle' => 'DESC'));
        $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array(),array('libelle' => 'DESC'));
        $ville    = $em->getRepository('EmBackendBundle:Villes')->findBy(array(),array('nom' => 'DESC'));

        /* if(!$infosite){
             throw new NotFoundHttpException('Aucune informations existante');

         }*/
        return $this->render('::frontend/blocks/menuPageRight.html.twig',
            array('informations' => $infosite, 'pays'=> $pays,
                'status'=> $status, 'type'=> $type, 'ville' => $ville));

    }

    public function blockPopSearchAction(){
        return $this->render('::frontend/blocks/blockPopSearch.html.twig');
    }

    public function blockLeftSearchAction(){
        return $this->render('::frontend/blocks/blockLeftSearch.html.twig');
    }

    public function listeHotelByVilleAction(Request $request, $ville = null){
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Agences')->recupAgencebyville($ville);
         //  var_dump($dataentity);exit;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('EmFrontendBundle:Layouts:listehotelsbyville.html.twig', array('pagination' => $pagination, 'dataentity' => $dataentity, 'ville' => $ville));

    }

    public function listeHotelByEtoileAction(Request $request, $grade= null){
        $em = $this->getDoctrine()->getManager();
        $grade = $this->get('nzo_url_encryptor')->decrypt($grade) ;

        $dataentity = $em->getRepository('EmBackendBundle:Agences')->recupAgencebyetoile($grade);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );
        //  var_dump($dataentity);exit;
        return $this->render('EmFrontendBundle:Layouts:listehotelsbyetoile.html.twig', array('pagination' => $pagination,'dataentity' => $dataentity, 'etoile' => $grade));

    }


    public function countAgenceByVilleAction( $ville = null){

    }

    public function blockLeftSearchByvilleAction(){
        return $this->render('::frontend/blocks/blockLeftSearchByville.html.twig');
    }
    public function blockTopareSliderAction(){

        $em = $this->getDoctrine()->getManager();
        $slider = $em->getRepository('EmBackendBundle:Slider')->findBy(array('enabled' => true),array('id' => 'DESC'));

        return $this->render('::frontend/blocks/topareaSlide2.html.twig', array('slider' => $slider));
    }


    public function blockslisteChambreAgenceAction(){
        return $this->render('EmFrontendBundle:Blocks:blockslistechambreagence.html.twig');
    }

    public function listeImageAgenceAction($entity){
        $em = $this->getDoctrine()->getManager();
        $imagesentity = $em->getRepository('EmBackendBundle:Imagesmultiple')->findOneBy(array('agence' => $entity));

        $allimagesentity = $em->getRepository('EmBackendBundle:Imagesmultiple')->findBy(array('agence' => $entity));


        return $this->render('EmFrontendBundle:Blocks:listeimageagence.html.twig',array('imagedata' => $imagesentity, 'allimagesentity' => $allimagesentity));
    }
    public function listeImageImmoAction($entity){
        $em = $this->getDoctrine()->getManager();
        $imagesentity = $em->getRepository('EmBackendBundle:Imagesmultipleimmo')->findOneBy(array('bienimmo' => $entity));

        $allimagesentity = $em->getRepository('EmBackendBundle:Imagesmultipleimmo')->findBy(array('bienimmo' => $entity));


        return $this->render('EmFrontendBundle:Blocks:listeimageimmo.html.twig',array('imagedata' => $imagesentity, 'allimagesentity' => $allimagesentity));
    }
    public function listeImageImmoSingleAction($entity){
        $em = $this->getDoctrine()->getManager();
        $imagesentity = $em->getRepository('EmBackendBundle:Imagesmultipleimmo')->findOneBy(array('bienimmo' => $entity));


        return $this->render('EmFrontendBundle:Blocks:listeimageimmosingle.html.twig',array('imagedata' => $imagesentity));
    }
    public function headerMenuFrontendAction($slug)
    {
        // ...
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $hotels = $em->getRepository('EmBackendBundle:Agences')->findAll();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));

        $pays    = $em->getRepository('EmBackendBundle:Pays')->findBy(array(),array('libelle' => 'DESC'));
        $status  =    $em->getRepository('EmBackendBundle:Statusimmo')->findBy(array(),array('libelle' => 'DESC'));
        $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array(),array('libelle' => 'DESC'));
        $ville    = $em->getRepository('EmBackendBundle:Villes')->findBy(array(),array('nom' => 'DESC'));
        $form = $this->container->get('form.factory')->create(new HotelRechercheType());


        $typeimmoencours    = $em->getRepository('EmBackendBundle:Typeimmo')->findOneBy(array('slug' =>$slug),array());


        return $this->render('::frontend/blocks/headerMenuFrontend2.html.twig', array('form' => $form->createView(), 'hotels'=> $hotels,
            'user' => $user, 'informations' =>$infosite,
            'pays' => $pays, 'status'=> $status, 'type' => $type, 'ville' => $ville, 'typeencours'=>$typeimmoencours, 'slug' => $slug

        ));
    }
    public function searchFormAction()
    {
        // ...Recherche avancer Side bar right
        $em = $this->getDoctrine()->getManager();

        $hotels = $em->getRepository('EmBackendBundle:Agences')->findAll();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));

        $pays    = $em->getRepository('EmBackendBundle:Pays')->findBy(array(),array('libelle' => 'DESC'));
        $status  =    $em->getRepository('EmBackendBundle:Statusimmo')->findBy(array(),array('libelle' => 'DESC'));
        $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array(),array('libelle' => 'DESC'));
        $ville    = $em->getRepository('EmBackendBundle:Villes')->findBy(array(),array('nom' => 'DESC'));
        $form = $this->container->get('form.factory')->create(new HotelRechercheType());

        return $this->render('::frontend/blocks/searchform.html.twig', array('form' => $form->createView(), 'hotels'=> $hotels,
            'informations' =>$infosite,
            'pays' => $pays, 'status'=> $status, 'type' => $type, 'ville' => $ville

        ));
    }
    public function formreservationrightAction()
    {
        // ...Recherche avancer Side bar right
        $em = $this->getDoctrine()->getManager();

        $hotels = $em->getRepository('EmBackendBundle:Agences')->findAll();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));

        $pays    = $em->getRepository('EmBackendBundle:Pays')->findBy(array(),array('libelle' => 'DESC'));
        $status  =    $em->getRepository('EmBackendBundle:Statusimmo')->findBy(array(),array('libelle' => 'DESC'));
        $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array(),array('libelle' => 'DESC'));
        $ville    = $em->getRepository('EmBackendBundle:Villes')->findBy(array(),array('nom' => 'DESC'));

        $form = $this->container->get('form.factory')->create(new HotelRechercheType());

        return $this->render('::frontend/blocks/formreservationright.html.twig', array('form' => $form->createView(), 'hotels'=> $hotels,
            'informations' =>$infosite,
            'pays' => $pays, 'status'=> $status, 'type' => $type, 'ville' => $ville

        ));
    }
    public function formReservationAction($idbien = null)
    {
        // ...Recherche avancer Side bar right

        return $this->render('::frontend/blocks/formreservation.html.twig', array( 'idbien' => $idbien

        ));
    }

    public function rechercherAction()
    {
        $request = $this->container->get('request');

        if($request->isXmlHttpRequest())
        {
            $motcle = '';
            $motcle = $request->request->get('motcle');

            $em = $this->getDoctrine()->getManager();

            if($motcle != '')
            {
                $qb = $em->createQueryBuilder();

                $qb->select('a')
                    ->from('EmBackendBundle:Agences', 'a')
                    ->where("a.nom LIKE :motcle LIKE :motcle")
                    ->orderBy('a.nom', 'ASC')
                    ->setParameter('motcle', '%'.$motcle.'%');
                //test de concatenation de ta

                $query = $qb->getQuery();
                $hotels = $query->getResult();
            }
            else {
                $hotels = $em->getRepository('EmBackendBundle:Agences')->findAll();
            }

            return $this->render('::frontend/blocks/headerMenuFrontend.html.twig', array('hotels' => $hotels));

        }
        else {
            return $this->listerAction();
        }
    }





    public function reservationAction(Request $request, $idbien = null){

        $em = $this->getDoctrine()->getManager();
        $prixtotal = 0;
        //On verfifie si une session est en cours
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));
        $user = $this->get('security.context')->getToken()->getUser();

        //decrypt
        //$chambreid= $this->get('nzo_url_encryptor')->decrypt($idchambre) ;
        $databien = $em->getRepository('EmBackendBundle:Chambre')->find($idbien);
      //  $imageonechambre = $em->getRepository('EmBackendBundle:Imagesmultiplechambre')->findBy(array('chambre'=>$databien->getId()));

        // var_dump($dataagence);exit;
        // on recupere toutes les communes
       // $Allfonction = new Allfonction();

        if(!$databien){

            throw new NotFoundHttpException('Oups une erreur à été rencontrée ! ');
        }

        $verifDateStart = (isset($_POST['datestart'])) ? $_POST['datestart'] : null;



        //$prixtotal = $Allfonction->calculPrix($_POST['start'], $_POST['end'], $databien->getPrixchambre(), $_POST['chambre']);

        // var_dump( $prixtotal );exit;
        $nbjour       = (isset($_POST['nbjour']) &&  $_POST['nbjour'] <1) ? 1: $_POST['nbjour'] ;
        $prixtotal =  $databien->getPrixchambre() * (int) $nbjour ;
            $json = json_encode(array('datestart' => $verifDateStart ));

        //soit 25%
        $prixreserve = (25 * $prixtotal)/100;

        $response = new Response($json);
        $response->headers->set('Content-type', 'application/json');
   $this->get('session')->set('start', $_POST['datestart']);
        $this->get('session')->set('end', $_POST['dateend']);
        $this->get('session')->set('chambre', $_POST['chambre']);
        $this->get('session')->set('enfant', $_POST['enfant']);
        $this->get('session')->set('adulte', $_POST['adulte']);
        $this->get('session')->set('nbjour', $nbjour);
        $this->get('session')->set('prixtotal', $prixtotal);
        $this->get('session')->set('prixreserve',  $prixreserve);

        /*   ##Commentaire 14 janv
   // On redirige vers le Cinetpay

   $params['cpm_amount'] =  $prixtotal;
   $params['cpm_currency'] = "CFA";
   $params['apikey'] = "30949263158080b3648d031.75466673";//'949263158080b3648d031.75466673';
   $params['cpm_site_id'] = "955054";
   $params['cpm_trans_id'] = date("YmdHis");
   $params['cpm_trans_date'] = date("Y-m-d H:i:s");
   $params['cpm_payment_config'] = "SINGLE";
   $params['cpm_page_action'] = "PAYMENT";
   $params['cpm_version'] =  "V2";
   $params['cpm_language'] = "fr";

   $params['cpm_designation'] = "Mon produit de ref: ".$params['cpm_trans_id'];
   $params['cpm_custom'] = "payeur@homemobilite.com";
   $url   = "https://api.cinetpay.com/v1/?method=getSignatureByPost";
   $plateform = "PROD" ;
   $version = "V1";
   $formName = "goCinetPay";
   $params['notify_url'] = 'www.homemobilite.com/notify/';
   // return url
   $params['return_url'] = 'www.homemobilite.com/';
   // cancel url
   $params['cancel_url'] = 'https://homemobilite.com/mon-compte/ServiceLogin';
   $btnType = 5;
   $btnSize = 'large';
   $cinetPay = new CinetPay($params['cpm_site_id'], $params['apikey'], $plateform, $version);

   $flux_json =  $cinetPay->callCinetpayWsMethod((array) $params, $url);
   // $decodeText = html_entity_decode($flux_json);
   $signature = json_decode($flux_json, true);
   //  dump($array_flux_json);exit;
   //$signature = json_decode($signature, true);
   $params['signature'] = $signature;
*/
        //Si la session n'existe pas on redirige vers la liste des hotels
        //Pour une nouvelle reservation
        if(!$this->get('session')->get('start')){
            return $this->redirect($this->generateUrl('em_frontend_listehotels'));
        }

        if($this->get('security.context')->isgranted('ROLE_USER')){

             $entity = new Reservations();
             $entity->setNom($user->getNom());
             $entity->setPrenoms($user->getUsername());
             $entity->setPhone($user->getPhone());
             $entity->setEmail($user->getEmail());

            $form = $this->createForm(new ReservationsType(), $entity);
        }else{
            $form = $this->createForm(new ReservationsType(), new Reservations());
        }

        //On verifie si le formulaire a été soumis via Post

        $reservationsHandler = new ReservationsHandler($form, $request, $em );

         if($reservationsHandler->process()){

          $reservation = $reservationsHandler->onSuccess($this->get('session'), $databien) ;

            //On envoie un email a l hotelier et admin

            #service api
            $smsapi = $this->container->get('em_backend.SmsApi');
            $message = 'Nouvelle Reservation chambre code: '.$reservation->getNumeroreservation();
            $destinataire = $databien->getAgences()->getProprietaire()->getPhone().';'. $infosite->getMobile();
            //On execute l'api sms

            //$smsapi->isSmsapi($destinataire, $message);

            #### Api Cintepay #########
          //    $apimobilemoney =  $this->container->get('em_backend.CinetPay');

            //  dump($apimobilemoney->isCinetpayapi());exit;
            //On envoie un email
            $message = \Swift_Message::newInstance()

                 ->setSubject('Nouvelle Reservation code:'.$reservation->getNumeroreservation())
                 ->setFrom('infos@homemobilite.com')
                 ->setTo($infosite->getEmail(), $databien->getAgences()->getProprietaire()->getEmail())
                 ->setBody( $databien->getAgences()->getNom().' a une nouvelle reservation plus d\'infos');

            // Retour au service mailer, nous utilisons sa méthode « send() » pour envoyer notre $message
                $this->get('mailer')->send($message);

                if($_POST['reservations']["modepayement"] == "Payer_a_hotel"){
                    return $this->redirect($this->generateUrl('em_frontend_reservartion_success',array('numreservat' => $this->get('nzo_url_encryptor')->encrypt($reservation->getNumeroreservation()) )));
                }

            ####Code insertion table commande Mobilemoney##
            $Commande = new Commande();
            //

            if($reservation->getId()){
//                 $reserv = $em->getRepository('EmFrontendBundle:Reservations')->findOneBy(array('id' => $reservation->getId()));

                //A decommenter après

                 $Commande->setDatecreation($params['cpm_trans_date']);
                 $Commande->setTransid($params['cpm_trans_id']);
                 $Commande->setSignature($params['signature']);
                 $Commande->setMontant($params['cpm_amount']);
                 $Commande->setReservations($reservation);
                 $em->persist($Commande);
                 $em->flush();
                return $this->redirect($this->generateUrl('em_frontend_reservartion_success',array('numreservat' => $this->get('nzo_url_encryptor')->encrypt($reservation->getNumeroreservation()) )));

            }




             //   $response = new JsonResponse();
              //dump($request);exit;
              // return $response->setData(array('data',$this->get('nzo_url_encryptor')->encrypt($numeroreservation)));
               // return $this->redirect($this->generateUrl('em_frontend_reservartion_success',array('numreservat' => $this->get('nzo_url_encryptor')->encrypt($numeroreservation) )));

         }

        return $this->render('EmFrontendBundle:Layouts:reservation.html.twig', array('form' => $form->createView(), 'chambre' => $databien,

         /*'params' => $params*/));


    }


    public function clientReservationAction(Request $request){

           $adultes = 'tom';
        $response = new JsonResponse();

        if($request->isXmlHttpRequest()) {

            return $this->redirect($this->generateUrl('em_frontend_reservartion'));
        }

        return $response->setData(array('adulte' => $adultes));
    }




    public function searchVilleCommuneAction($villecommune)
    {
        $em = $this->getDoctrine()->getManager();
        $villeCommunes = $em->getRepository('EmBackendBundle:Villes')->findByVilleCommune($villecommune);

        if (!$villeCommunes) {
            $ville = null;

        } else {
            $ville = $villeCommunes;
        }

        $response = new JsonResponse();
     return  $response->setData(array('ville' => $ville));

    }



    public function labelVilleAction(){
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('EmBackendBundle:Villes')->findBy(array(), array('nom' =>'ASC'));

        return $this->render('EmFrontendBundle:Blocks:label.html.twig',array('dataentity' => $entity));

    }
    public function labelCommuneAction(){
        $em = $this->getDoctrine()->getManager();
        $entity  = $em->getRepository('EmBackendBundle:Communes')->findBy(array(), array('nom' =>'ASC'));

        return $this->render('EmFrontendBundle:Blocks:label.html.twig',array('dataentity' => $entity));

    }
    public function blockLeftSearchDetailVilleAction(){

        return $this->render('::frontend/blocks/blockLeftSearchDetailVille.html.twig');
    }

    public function renderCommentaireAction(Request $request, $idagence = null){
        $em = $this->getDoctrine()->getManager();
        $entity  = $em->getRepository('EmBackendBundle:Agences')->find($idagence);
        $commentaire  = $em->getRepository('EmBackendBundle:Commentaire')->recupCommentairebyhotel($entity);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $commentaire,
            $request->query->get('tracker', 1)/*page number*/,
            7/*limit per page*/
        );
        return $this->render('EmFrontendBundle:Blocks:commentairerender.html.twig',array('pagination' => $pagination,'agencesentity' => $entity));
    }

    public function renderCommentaireSlideAction(Request $request, $ville = null){
        $em = $this->getDoctrine()->getManager();
        $commentaire  = $em->getRepository('EmBackendBundle:Commentaire')->recupCommentairebyville($ville);
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $commentaire,
            $request->query->get('tracker', 1)/*page number*/,
            1/*limit per page*/
        );
        return $this->render('EmFrontendBundle:Blocks:commentairerenderslide.html.twig',array('pagination' => $pagination));
    }

    public function addCommentaireAction(Request $request, $idagence = null)
    {


        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();
        $agence  = $em->getRepository('EmBackendBundle:Agences')->find($idagence);

        $commentaireHandler = new CommentaireHandler($this->createForm(new CommentaireType(),new Commentaire()), $request, $em, $agence, $user );

        //On affecte les donnees POST aux variables du formulaire contact
        if ($commentaireHandler->process($user,  $agence)) {


               $request->getSession()->getFlashBag()->add('Notice', 'Merci, votre avis a été pris en compte l\'equipe Afrikhotel vous dit Merci !.');
               return $this->redirect($this->generateUrl('em_client_commentaire'));



        }

        return $this->render('EmFrontendBundle:Blocks:formcommentaire.html.twig', array('form' => $commentaireHandler->getForm()->createView(), 'idagence' => $idagence));
    }


    public function renderAutreHotelAction(Request $request, $ville = null){
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Agences')->recupAgencebyville($ville);
        //  var_dump($dataentity);exit;
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            6/*limit per page*/
        );
        return $this->render('EmFrontendBundle:Blocks:autrehotel.html.twig', array('pagination' => $pagination,'ville' => $ville));

    }

    public function addNewsLetterAction(Request $request){

        $em = $this->getDoctrine()->getManager();
        $user = new User();

        if($request->isMethod('POST')){

            //On verifie si l\'email existe
               $postemail = (string) $_POST['newsletter'];
            $email = $em->getRepository('EmBackendBundle:User')->findOneBy(array('email' => $postemail));
            $lastuser = $em->getRepository('EmBackendBundle:User')->findOneBy(array(), array('id' => 'DESC'));
           if(!$email){

               $user->setUsername('newsletter-user-'.$lastuser->getId());
               $user->setUsernameCanonical('newsletter-user-'.$lastuser->getId());
               $user->setEmail($_POST['newsletter']);
               $user->setUsernameCanonical($_POST['newsletter']);
               $user->setPassword('l5Tq/vNbl+gRadNTSssTnZcfVp8iUqJy/Sukbm5zGjceqnm/a5dqvgD6yoLQrfK9bhom/paaGRlD0k/rDdGTiA==');
               $user->setEnabled(false);
               $user->setLocked(true);
               $user->setExpired(false);
               $user->setCredentialsExpired(false);
               $user->setRoles(array('ROLE_USER'));
               $user->setDateinscrit(new \DateTime());
               $em->persist($user);
               $em->flush();
               $request->getSession()->getFlashBag()->add('Noticenewsletter', 'Votre inscription a été pris en compte Merci !');


           }else{
               $request->getSession()->getFlashBag()->add('Noticenewsletter', 'Votre email existe déjà chez Afrikhotel Merci!');

           }
           return $this->redirect($this->generateUrl('em_frontend_homepage'));

        }
    }


    public function searchingbypriceAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        if($request->isMethod('GET')){

            //On verifie si l\'email existe
            $prix = (int) $_GET['prix'];
            $dataentity = $em->getRepository('EmBackendBundle:Agences')->recupAgencebyprix($prix);

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $dataentity,
                $request->query->get('tracker', 1)/*page number*/,
                10/*limit per page*/
            );
            return $this->render('EmFrontendBundle:Layouts:listehotelsbyprix.html.twig', array('pagination' => $pagination,'dataentity' => $dataentity, 'prixsearch' => $prix));

        }
        return $this->redirect($this->generateUrl('em_frontend_homepage'));


    }



    public function listeProprietesAction()
    {

        return $this->render('EmFrontendBundle:files:listeproprietes.html.twig');
    }

    public function renderMenuRightInfoUserAction(){

        $em = $this->getDoctrine()->getManager();

        return $this->render('EmFrontendBundle:renderTwig:menuRightInfoUser.html.twig');

    }


    public function detailProprietesAction()
    {

        return $this->render('EmFrontendBundle:files:detailproprietes.html.twig');
    }


    /*
     * Liste des hotels
     */
    public function listeHotelsByAction(Request $request,Pays $pays= null, $slug = null)
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Agences')->recupListeHotelByCountry($pays->getId());
        $paysall =  $em->getRepository('EmBackendBundle:Pays')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('EmFrontendBundle:files:listehotelsby.html.twig', array('pagination' =>$pagination, 'dataentity' => $dataentity, 'pays' => $pays, 'paysall' => $paysall));
    }

     public function listeHotelsByAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $ref = 'liste-propriete-hotel';
             $dataentity = $em->getRepository('EmBackendBundle:Agences')->findAll(array('locked' => false) , array('id' => 'DESC'));
             $news = $em->getRepository('EmBackendBundle:News')->findOneBy(array('slug' =>'htelerie'));
             $paysall =  $em->getRepository('EmBackendBundle:Pays')->findAll();

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            25/*limit per page*/
        );
        return $this->render('EmFrontendBundle:files:listehotelsby.html.twig',
            array('pagination' =>$pagination, 'dataentity' => $dataentity,
                'service'=> $news, 'paysall' => $paysall, 'slug'=>$ref));
    }


    public function listeCategorieImmoAction(Request $request, $slug = null)
    {
        $em = $this->getDoctrine()->getManager();

        $donnee = $em->getRepository("EmBackendBundle:Bienimmo")->CategoriBien($slug);
        $dataentity = $em->getRepository('EmBackendBundle:Bienimmo')->recupListeImmoBy($slug);
        $news = $em->getRepository('EmBackendBundle:News')->findOneBy(array('slug' =>'services-immobiliers-d-entreprises'));
        $paysall =  $em->getRepository('EmBackendBundle:Pays')->findAll();
        $typeimmoencours    = $em->getRepository('EmBackendBundle:Typeimmo')->findOneBy(array('slug' =>$slug),array());

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $donnee,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('EmFrontendBundle:files:listecategorieimmo.html.twig',
            array('pagination' =>$pagination, 'dataentity' => $dataentity,
                'slug' => $slug,  'status' => $slug, 'paysall'=>$paysall, 'service' => $news, 'typeimmoencours'=>$typeimmoencours ));
    }

    //Recherche dans la table Bien immobilier
//
    public function rechercherImmoAction(Request $request, $pays = null, $categorie = null){

        $em = $this->getDoctrine()->getManager();

        $donnee = $em->getRepository('EmBackendBundle:Bienimmo')->SortByCountry($pays,$categorie);
        $paysall =  $em->getRepository('EmBackendBundle:Pays')->findAll();
        $news = $em->getRepository('EmBackendBundle:News')->findOneBy(array('slug' =>'services-immobiliers-d-entreprises'));
        $pays = $em->getRepository("EmBackendBundle:Pays")->findOneBy(array('id'=>$pays));
        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $donnee,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );

        return $this->render('EmFrontendBundle:files:listecategorieimmo.html.twig',
            array('pagination' =>$pagination,
                'slug' => $categorie,  'paysall'=>$paysall, 'service' => $news, 'Localite'=>$pays));

    }




    public function renderListeHotelsAction(Request $request )
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Agences')->findBy(array('locked'=> false), array('id' => 'DESC'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            2/*limit per page*/
        );

        return $this->render('EmFrontendBundle:renderTwig:renderlistehotelshome.html.twig', array('pagination' =>$pagination,'dataentity' => $dataentity));
    }


    public function renderListeImmoAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Bienimmo')->findBy(array('locked'=> false), array('id' => 'DESC'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            4/*limit per page*/
        );
        return $this->render('EmFrontendBundle:renderTwig:renderlisteimmohome.html.twig', array('pagination' =>$pagination, 'dataentity' => $dataentity));
    }

    public function renderNewsHomeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:News')->findBy(array(), array('id' => 'DESC'));

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            4/*limit per page*/
        );

        return $this->render('EmFrontendBundle:renderTwig:rendernewshome.html.twig', array('pagination' =>$pagination, 'dataentity' => $dataentity));
    }

    public function listeImmoAction(Request $request, $slug = null)
    {
        $em = $this->getDoctrine()->getManager();
        $ref = 'liste-proprietes';
        $dataentity = $em->getRepository('EmBackendBundle:Bienimmo')->recupListeImmoBy($slug);
        $news = $em->getRepository('EmBackendBundle:News')->findOneBy(array('slug' =>'services-immobiliers-d-entreprises'));
        $paysall =  $em->getRepository('EmBackendBundle:Pays')->findAll();
        $typeimmoencours    = $em->getRepository('EmBackendBundle:Typeimmo')->findOneBy(array('slug' =>$slug),array());

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('EmFrontendBundle:files:listeimmo.html.twig', array('pagination' =>$pagination, 'dataentity' => $dataentity,
            'slug' => $ref,  'status' => $slug, 'paysall'=>$paysall, 'service' => $news ,'typeimmoencours'=> $typeimmoencours));
    }

    public function listeImmoByAction(Request $request,Pays $pays= null, $slug = null)
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Bienimmo')->recupListeImmoByCountryAndSlug($pays->getId() , $slug);
        $paysall =  $em->getRepository('EmBackendBundle:Pays')->findAll();
        $typeimmoencours    = $em->getRepository('EmBackendBundle:Typeimmo')->findOneBy(array('slug' =>$slug),array());

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            10/*limit per page*/
        );
        return $this->render('EmFrontendBundle:files:listeimmo.html.twig', array('pagination' =>$pagination, 'dataentity' => $dataentity,
            'pays' => $pays, 'slug' => $slug,  'status' => $slug, 'paysall' => $paysall, 'typeimmoencours'=> $typeimmoencours));
    }


    public function detailImmoAction(Request $request, Bienimmo $bienimmo)
    {
        $em =$this->getDoctrine()->getManager();

        $entity = $em->getRepository('EmBackendBundle:Bienimmo')->find($bienimmo);
        // var_dump($dataagence);exit;
        // on recupere toutes les communes

        if(!$entity){

            throw new NotFoundHttpException('error');
        }

        $imagesentity = $em->getRepository('EmBackendBundle:Imagesmultipleimmo')->findBy(array('bienimmo' => $bienimmo));

        return $this->render('EmFrontendBundle:files:detailimmo.html.twig',
            array('entity' => $entity,
                'dataimages' => $imagesentity ));
    }


    public function renderRecommanderAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $dataentity = $em->getRepository('EmBackendBundle:Bienimmo')->findBy(array('recommander'=> true), array('id' => 'DESC'));


        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $dataentity,
            $request->query->get('tracker', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('EmFrontendBundle:renderTwig:renderrecommander.html.twig', array('pagination' =>$pagination, 'dataentity' => $dataentity));
    }


    public function rechercheMenuRightAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        if(isset($_POST) && isset($_POST['location']) && !empty($_POST['type'])
            && !empty($_POST['status']) && isset($_POST['min-price']) && isset($_POST['max-price'])

        ){

            $location =   (int)  $_POST['location'];
            $type     =  (int)   $_POST['type'];
            $status   =   (int)  $_POST['status'];
            $minprice =   (int)  $_POST['min-price'];
            $maxprice =   (int)  $_POST['max-price'];
            $statusentity = $em->getRepository('EmBackendBundle:Statusimmo')->find($status);
            if(!$statusentity){
                return $this->redirect($this->generateUrl('em_frontend_homepage'));
            }
            $typeentity = $em->getRepository('EmBackendBundle:Typeimmo')->find($type);

           $paysall =  $em->getRepository('EmBackendBundle:Pays')->findAll();
            $entity = $em->getRepository('EmBackendBundle:Bienimmo')->findMenuRightSearch($location , $type, $status, $minprice,$maxprice );

            $paginator  = $this->get('knp_paginator');
            $pagination = $paginator->paginate(
                $entity,
                $request->query->get('tracker', 1)/*page number*/,
                10/*limit per page*/
            );
            return $this->render('EmFrontendBundle:files:listeimmo.html.twig', array('pagination' =>$pagination, 'recherche' => 'RESULTAT RECHERCHE',  'dataentity' => $entity, 'slug' => $statusentity->getLibelle(),
                'paysall'=>$paysall,'status' => $typeentity->getLibelle() ));
        }


        return $this->redirect($this->generateUrl('em_frontend_homepage'));


    }


    public function  addBienimmoAction(Request $request){

        //Appel su service slide handler
        //On lien du dossier d upload
        $lienDossier = '/../../../../../web/bundles/emfrontend/assets/pics/immobilier/';
        $ref = 'soumettre-bienimmo';
        //appel de la class gestion des upload
        $em = $this->getDoctrine()->getManager();
        $user = $this->container->get('security.context')->getToken()->getUser();


        $dataentity = $em->getRepository('EmBackendBundle:Pagesite')->findOneBy(array("id" => 7));


        $Handler = new BienimmoHandler($this->createForm(new BienimmoType(), new Bienimmo()), $request, $em);

        $uploadHandler = new UploadHandler($this->createForm(new BienimmoType(), new Bienimmo()),  $request, $em, $lienDossier);

        if ( $Handler->process()){

            // $dataImages = $uploadHandler->uploadImages('em_backendbundle_bienimmo');
            $entity =  $Handler->onSuccess();

            // on desactive
            $entity->setLocked(true);
            if ($entity) {
                if ($uploadHandler->uploadMultipleImagesimmo($lienDossier, $entity)) {
                    $request->getSession()->getFlashBag()->add('Notice', ' Votre demande  est en cours d\' examen chez ImmoOline, vous serez bientôt notifié(e) !');

                    return $this->redirect($this->generateUrl('em_frontend_addbienimmo'));
                }
            }
            else {
                //On declenche une erreur lié a l'upload image
                throw $this->createNotFoundException(
                    'Error of système contact E-mitic Agency ! ');
            }

        }
        return $this->render('EmFrontendBundle:files:soumettrebien.html.twig',
            array('form' => $Handler->getForm()->createView(), 'pagesite' => $dataentity, 'slug'=>$ref));

    }



    /*
    * Liste des hotels
    */
    public function listeHotelsAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $etablissements = $em->getRepository('EmBackendBundle:Agences')->recupListeHotel();

        $hotels = $em->getRepository('EmBackendBundle:Agences')->findBy(array('locked'=>false, 'caracteristique' => "Hotel"));
        $appartements = $em->getRepository('EmBackendBundle:Agences')->findBy(array('locked'=>false, 'caracteristique' => "Appartement"));
        $residences = $em->getRepository('EmBackendBundle:Agences')->findBy(array('locked'=>false, 'caracteristique' => "Residence"));


        $paginator  = $this->get('knp_paginator');
        $hotelsall = $paginator->paginate(
            $hotels,
            $request->query->get('tracker', 1),//page number
            15//limit per page
        );
        $residencessall = $paginator->paginate(
            $residences,
            $request->query->get('tracker', 1),//page number
            15//limit per page
        );
        $appartementsall = $paginator->paginate(
            $appartements,
            $request->query->get('tracker', 1),//page number
            15//limit per page
        );

        return $this->render('EmFrontendBundle:files:listehotelsby.html.twig', array(
                'hotels' =>$hotelsall,
            'residences' =>$residencessall,
            'appartements' =>$appartementsall,
            'dataentity' => $etablissements
            )

              );
    }


}
