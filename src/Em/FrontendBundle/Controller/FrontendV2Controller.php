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


class FrontendV2Controller extends Controller
{

    /*
     * Page home
     */
    public function indexAction(Request $request)
    {
        $slug = 'home';
        $em = $this->getDoctrine()->getManager();
        $agences = $em->getRepository('EmBackendBundle:Agences')->findBy(array('locked' => false), array('id'=> 'ASC'));
        $paginator  = $this->get('knp_paginator');
        $agencessall = $paginator->paginate(
            $agences,
            $request->query->get('tracker', 1),//page number
            6//limit per page
        );
        return   $this->render('::FrontendV2/files/index.html.twig', ['agences' => $agencessall]);
    }


    public function renderListeTypeImmoAction(){
        $em = $this->getDoctrine()->getManager();
        $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array('publish' => true),array('libelle' => 'DESC'));
        return $this->render('EmFrontendBundle:renderTwig:renderlistetypeimmo.html.twig', array('typeimmo'=>$type));
    }

    /*
     * header
     */
    public function headerAction()
    {
        // ...
        $em = $this->getDoctrine()->getManager();
       /* $user = $this->get('security.context')->getToken()->getUser();

        $hotels = $em->getRepository('EmBackendBundle:Agences')->findAll();
        $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));

        $pays    = $em->getRepository('EmBackendBundle:Pays')->findBy(array(),array('libelle' => 'DESC'));
        $status  =    $em->getRepository('EmBackendBundle:Statusimmo')->findBy(array(),array('libelle' => 'DESC'));
        $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array(),array('libelle' => 'DESC'));
        $ville    = $em->getRepository('EmBackendBundle:Villes')->findBy(array(),array('nom' => 'DESC'));
        $form = $this->container->get('form.factory')->create(new HotelRechercheType());


        $typeimmoencours    = $em->getRepository('EmBackendBundle:Typeimmo')->findOneBy(array('slug' =>$slug),array());

*/
        return $this->render('::FrontendV2/blocks/header.html.twig');
    }
    public function searchformAction()
    {
        // ...
        $em = $this->getDoctrine()->getManager();
        /* $user = $this->get('security.context')->getToken()->getUser();

         $hotels = $em->getRepository('EmBackendBundle:Agences')->findAll();
         $infosite = $em->getRepository('EmBackendBundle:Informationsite')->findOneBy(array('id' => 1));

         $pays    = $em->getRepository('EmBackendBundle:Pays')->findBy(array(),array('libelle' => 'DESC'));
         $status  =    $em->getRepository('EmBackendBundle:Statusimmo')->findBy(array(),array('libelle' => 'DESC'));
         $type    = $em->getRepository('EmBackendBundle:Typeimmo')->findBy(array(),array('libelle' => 'DESC'));
         $ville    = $em->getRepository('EmBackendBundle:Villes')->findBy(array(),array('nom' => 'DESC'));
         $form = $this->container->get('form.factory')->create(new HotelRechercheType());


         $typeimmoencours    = $em->getRepository('EmBackendBundle:Typeimmo')->findOneBy(array('slug' =>$slug),array());

 */
        return $this->render('::FrontendV2/renderTwig/searchform.html.twig');
    }
    /*
     * end header
     */


    /*
     * Footer
     */

    public function footerPageAction(){

        $em = $this->getDoctrine()->getManager();

        return $this->render('::FrontendV2/blocks/footer.html.twig');
    }

    public function listeImageAgenceAction($entity){
        $em = $this->getDoctrine()->getManager();
        $imagesentity = $em->getRepository('EmBackendBundle:Imagesmultiple')->findOneBy(array('agence' => $entity));

        $allimagesentity = $em->getRepository('EmBackendBundle:Imagesmultiple')->findBy(array('agence' => $entity));


        return $this->render('::FrontendV2/renderTwig/listeimageagence.html.twig',array('imagedata' => $imagesentity, 'allimagesentity' => $allimagesentity));
    }

    /*
     * end footer
     */

    public function rechercheHomeAction(Request $request){
        $em = $this->getDoctrine()->getManager();

        if(isset($_POST) && !empty($_POST) ){

            $location =   (string)   isset($_POST['location'])? $_POST['location']: null;
            //    $type     =  (int)   $_POST['type'];
            $nbrepiece  =    (int) $_POST['adulte'];
            $start = isset($_POST['datestart'])? $_POST['datestart']: null;
            $end = isset($_POST['dateend'])? $_POST['dateend']: null;
            $chambre = isset($_POST['chambre'])? $_POST['chambre']: null;
            $enfant = isset($_POST['enfant'])? $_POST['enfant']: null;
            $adulte = isset($_POST['adulte'])? $_POST['adulte']: null;


            //session
            $this->get('session')->set('start', $start);
            $this->get('session')->set('end', $end);
            $this->get('session')->set('chambre', $chambre);
            $this->get('session')->set('enfant', $enfant);
            $this->get('session')->set('adulte', $adulte);
            $this->get('session')->set('location',  $location);

            $etablissements = $em->getRepository('EmBackendBundle:Agences')->findHomeSearch($location);

            $hotels = $em->getRepository('EmBackendBundle:Agences')->findHomeSearchCaracterisque($location, 'Hotel');
            $appartements = $em->getRepository('EmBackendBundle:Agences')->findHomeSearchCaracterisque($location, 'Appartement');
            $residences = $em->getRepository('EmBackendBundle:Agences')->findHomeSearchCaracterisque($location, 'Residence');


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

        ;



            return $this->render('::FrontendV2/files/resultatsrecherche.html.twig', array(
                'recherche' => 'RESULTAT RECHERCHE',
                'hotels' =>$hotelsall,
                'residences' =>$residencessall,
                'appartements' =>$appartementsall,
                'dataentity' => $etablissements

            ));


        }





        return $this->redirect($this->generateUrl('em_frontend_homepage'));


    }

    public function searchFormRightAction()
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

        return $this->render('::FrontendV2/renderTwig/searchformright.html.twig', array('form' => $form->createView(), 'hotels'=> $hotels,
            'informations' =>$infosite,
            'pays' => $pays, 'status'=> $status, 'type' => $type, 'ville' => $ville

        ));
    }

    public function detailAgenceAction(  Agences $idagence = null)
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

        /*if(isset($dataagencechambre[0])){
            $dataagencechambresingle = $dataagencechambre[0];
        }else{
            throw new NotFoundHttpException('Désolé Cette Agence na pas de chambres disponibles ! ');

        }*/
        $dataallrooms = $em->getRepository('EmBackendBundle:Chambre')->recupAgenceAllChambre($dataagence);
        $imagesentity = $em->getRepository('EmBackendBundle:Imagesmultiple')->findBy(array('agence' => $dataagence));

        return $this->render('::FrontendV2/files/detailagence.html.twig',
            array('agence' => $idagence ,
                'dataimages' => $imagesentity , 'dataallroom' => $dataallrooms ,
            ));
    }



    /*
     * Menu left
     */


    public function menuLeftAction(){

        $em = $this->getDoctrine()->getManager();
        $dataentity = $em->getRepository('EmBackendBundle:Agences')->findOneBy(array(), array('id'=> 'ASC'));
        $imagesentity = $em->getRepository('EmBackendBundle:Imagesmultiple')->findOneBy(array('agence' => $dataentity));

        return $this->render('::FrontendV2/renderTwig/menuleft.html.twig', array("agence"=> $dataentity, 'dataimage'=>  $imagesentity));

    }



    public function chambreencoursReservationAction(Chambre $reference = null)
    {

        $em =$this->getDoctrine()->getManager();

        $chambre = $em->getRepository('EmBackendBundle:Chambre')->find($reference);

        return $this->render('::FrontendV2/files/detailchambre.html.twig',
            array('chambre' => $chambre ));
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

        $verifDateStart = (isset($_POST['start'])) ? $_POST['start'] : null;



        //$prixtotal = $Allfonction->calculPrix($_POST['start'], $_POST['end'], $databien->getPrixchambre(), $_POST['chambre']);

        // var_dump( $prixtotal );exit;
        $nbjour       = (isset($_POST['nbjour']) &&  $_POST['nbjour'] <1) ? 1: $_POST['nbjour'] ;
        $prixtotal =  $databien->getPrixchambre() * (int) $nbjour ;
        $json = json_encode(array('start' => $verifDateStart ));

        //soit 25%
        $prixreserve = (25 * $prixtotal)/100;

        $response = new Response($json);
        $response->headers->set('Content-type', 'application/json');
        $this->get('session')->set('start', $_POST['start']);
        $this->get('session')->set('end', $_POST['end']);
        $this->get('session')->set('chambre', $_POST['chambre']);
        $this->get('session')->set('enfant', $_POST['enfant']);
        $this->get('session')->set('adulte', $_POST['adulte']);
        $this->get('session')->set('nbjour', $nbjour);
        $this->get('session')->set('prixtotal', $prixtotal);
        $this->get('session')->set('prixreserve',  $prixreserve);

           ##Commentaire 14 janv
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
/*
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
   */
  //* $flux_json =  $cinetPay->callCinetpayWsMethod((array) $params, $url);
   // $decodeText = html_entity_decode($flux_json);
   //*$signature = json_decode($flux_json, true);
   //  dump($array_flux_json);exit;
   //$signature = json_decode($signature, true);
   //*$params['signature'] = $signature;

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

        return $this->render('::FrontendV2/files/reservation.html.twig', array('form' => $form->createView(), 'chambre' => $databien,

            /*'params' => $params*/));


    }

    public function reservationSuccessAction($numreservat = null){

        //decrypt
        $numreservation = $this->get('nzo_url_encryptor')->decrypt($numreservat) ;

        $em = $this->getDoctrine()->getManager();
        $datareservation = $em->getRepository('EmFrontendBundle:Reservations')->findOneBy(array('numeroreservation' => $numreservation));

        // var_dump($dataagence);exit;
        // on recupere toutes les communes
        if(!$datareservation){
            throw new NotFoundHttpException('Oups une erreur à été rencontrée ! ');
        }
        $datareservation->setPrixtotal(number_format($datareservation->getPrixtotal()));


        //On send le mail et

        return $this->render('::FrontendV2/files/reservation-success.html.twig', array( 'reservation' => $datareservation));

    }

}
