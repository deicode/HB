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

class RootController extends Controller
{
    public function indexAction()
    {
        //Buffer des nombres
        //Index Action principale
        // Verifie le role
        //redirige vers le controlleur selon le role


        $pathredirect = 'em_frontend_homepage'; //Lien de redirection default


        //On verifie la validité de l entité


        if ($this->isGranted('ROLE_SUPER_ADMIN')) {

            $pathredirect  =  'em_user_root_homepage';

        }elseif($this->isGranted('ROLE_ADMIN') or $this->isGranted('ROLE_SUPERVISEUR')) {

            $pathredirect  =  'em_user_root_homepage';
            //dump('exit');exit;

        }elseif($this->isGranted('ROLE_PROPRIETAIRE') ) {

            $pathredirect  =  'em_user_proprietaire_homepage';

        }


        return $this->redirect($this->generateUrl($pathredirect));

    }



}