<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 21/01/16
 * Time: 10:25
 */
namespace  Em\BackendBundle\Form\Handler;


use Doctrine\ORM\EntityManager;
use Em\BackendBundle\Entity\Imagesmultiple;
use Em\BackendBundle\Entity\Imagesmultipleimmo;
use Em\FrontendBundle\Entity\Fichiers;
use Em\FrontendBundle\Entity\Images;

use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UploadHandler{

   protected $_request;
   protected $_form;
   protected $_em;
   protected $_entity_image ;
   protected $_entity_fichier ;
   protected $_entity_imageType;
   protected $_entity_fichiersType;
   protected $_lienDossier;

    public  function  __construct(Form $form,  Request $request, EntityManager $em, $lienDossier){

        $this->_em = $em;
        $this->_form = $form;
        $this->_request = $request;
        $this->_lienDossier = $lienDossier;

        $this->_entity_fichier = new Fichiers();
        $this->_entity_image = new Images();

       

    }


    public function uploadFichiers( )
    {


        foreach ($_FILES[$this->_form->getName()]['tmp_name'] as $key => $tmp_name) {

            $data['file_name'] = $file_name = $_FILES[$this->_form->getName()]['name'][$key]["url"];
            // var_dump($_FILES["eload_blogbundle_notreblog"]['size'][$key]["url"]);exit;
            $data['file_size'] = $file_size = $_FILES[$this->_form->getName()]['size'][$key]["url"];
            $data['file_tmp'] = $file_tmp = $_FILES[$this->_form->getName()]['tmp_name'][$key]["url"];
            $data['file_type'] = $file_type = $_FILES[$this->_form->getName()]['type'][$key]["url"];

            $name_array = explode('.', $data['file_name']);
            $file_type = $name_array[sizeof($name_array) - 1];

            $valide_filetype = array('csv', 'zip', 'rar', 'xls');


            if ($file_size > 209715200) {
                $errors[] = 'Desolé le fichier ne peut depasser 5M';
            }


            $desired_dir = __dir__ . $this->_lienDossier;

            if (in_array(strtolower($file_type), $valide_filetype)) {

                if (is_dir($desired_dir) == false) {
                    mkdir("$desired_dir", 0755);        // Create directory if it does not exist
                }
                if (is_dir("$desired_dir/" . $file_name) == false) {
                    move_uploaded_file($file_tmp, "$desired_dir/" . $file_name);
                } else {                                    // rename the file if another one exist
                    $new_dir = "$desired_dir/" . $file_name . time();
                    rename($file_tmp, $new_dir);
                }

                //Declaration et initialisation

                $this->_entity_fichier->setUrl($desired_dir);
                $this->_entity_fichier->setAlt($name_array[0]);
                $this->_entity_fichier->setTitle($data['file_name']);
                $this->_entity_fichier->setDateadd(new \Datetime());
            } else {

                $this->_request->getSession()->getFlashBag()->add('Notice', ' Erreur survenue upload incorecte ! !');

            }

        }

    } //Fin fonction


    public function uploadImages($nameForm)
    {


        foreach ($_FILES[$nameForm]['tmp_name'] as $key => $tmp_name) {

            $data['file_name'] = $file_name = $_FILES[$nameForm]['name'][$key]["url"];
            // var_dump($_FILES["eload_blogbundle_notreblog"]['size'][$key]["url"]);exit;
            $data['file_size'] = $file_size = $_FILES[$nameForm]['size'][$key]["url"];
            $data['file_tmp'] = $file_tmp = $_FILES[$nameForm]['tmp_name'][$key]["url"];
            $data['file_type'] = $file_type = $_FILES[$nameForm]['type'][$key]["url"];

            $name_array = explode('.', $data['file_name']);
            $file_type = $name_array[sizeof($name_array) - 1];

            $valide_filetype = array('jpg', 'jpeg', 'png');


            if ($file_size > 20097152) {
                $errors[] = 'Desolé le fichier ne peut depasser 5M';
            }
            //var_dump($_FILES);exit;

            // $desired_dir='GALERIES/'.$data['titre'];

            $desired_dir = __dir__ . $this->_lienDossier;
           //var_dump($desired_dir);exit;
            if (in_array(strtolower($file_type), $valide_filetype)) {

                if (is_dir($desired_dir) == false) {
                    mkdir("$desired_dir", 0755);        // Create directory if it does not exist
                }
                if (is_dir("$desired_dir/" . $file_name) == false) {
                    move_uploaded_file($file_tmp, "$desired_dir/" . $file_name);
                } else {                                    // rename the file if another one exist
                    $new_dir = "$desired_dir/" . $file_name . time();
                    rename($file_tmp, $new_dir);
                }

                //Declaration et initialisation

                $this->_entity_image->setUrl($nameForm);
                $this->_entity_image->setAlt($name_array[0]);
                $this->_entity_image->setTitle($data['file_name']);
                $this->_entity_image->setDateadd(new \Datetime());

                //On retourn l'entite
                return $this->_entity_image;

            } else {

                return false;
                //$this->_request->getSession()->getFlashBag()->add('Notice', ' Erreur survenue upload incorecte ! !');

            }

        }

    } //Fin fonction


    public function  uploadMultipleImagesAgence($liendossier, $agence){
        if (isset($_FILES['files'])) {
            // var_dump($_FILES);exit;

            $errors = array();
            $data = array();

///            $data['name'] = htmlentities($_POST[$nameForm]["name"]);



            foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                $data['file_name'] = $file_name = $_FILES['files']['name'][$key];
                $data['file_size'] = $file_size = $_FILES['files']['size'][$key];
                $data['file_tmp'] = $file_tmp = $_FILES['files']['tmp_name'][$key];
                $data['file_type'] = $file_type = $_FILES['files']['type'][$key];
                $name_array = explode('.', $data['file_name']);
                $file_type  = $name_array[sizeof($name_array) - 1];

                $valide_filetype = array('jpg', 'jpeg', 'png');


                if ($file_size > 2097152) {
                    $errors[] = 'Desolé le fichier ne peut depasser 5M';
                }
                //var_dump($_FILES);exit;

                // $desired_dir='GALERIES/'.$data['titre'];

                $desired_dir =  __dir__.$liendossier;

                if(in_array(strtolower($file_type), $valide_filetype)){

                    if (is_dir($desired_dir) == false) {
                        mkdir("$desired_dir", 0755);        // Create directory if it does not exist
                    }
                    if (is_dir("$desired_dir/" . $file_name) == false) {
                        move_uploaded_file($file_tmp, "$desired_dir/" . $file_name);
                    } else {                                    // rename the file if another one exist
                        $new_dir = "$desired_dir/" . $file_name . time();
                        rename($file_tmp, $new_dir);
                    }

                    //Declaration et initialisation
                    $this->_entity_image = new Imagesmultiple();

                    $this->_entity_image->setUrl('immobilier');
                    $this->_entity_image->setAlt($name_array[0]);
                    $this->_entity_image->setTitle($data['file_name']);
                    $this->_entity_image->setDateadd(new \Datetime());
                    //  var_dump($agence);exit;
                    $this->_entity_image->setAgence($agence);

                    $this->_em->persist($this->_entity_image);



                }

                else {

                    throw new NotFoundHttpException('Erreur survenue pendant le transfère des images !');
                }


            }
            if (empty($errors)) {
                $this->_em->flush();
                return true;

            }elseif(!empty($errors)){

                return false;
            }
        }
    }

    public function  uploadMultipleImagesimmo($liendossier, $agence){
        if (isset($_FILES['files'])) {
            // var_dump($_FILES);exit;

            $errors = array();
            $data = array();

///            $data['name'] = htmlentities($_POST[$nameForm]["name"]);



            foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                $data['file_name'] = $file_name = $_FILES['files']['name'][$key];
                $data['file_size'] = $file_size = $_FILES['files']['size'][$key];
                $data['file_tmp'] = $file_tmp = $_FILES['files']['tmp_name'][$key];
                $data['file_type'] = $file_type = $_FILES['files']['type'][$key];
                $name_array = explode('.', $data['file_name']);
                $file_type  = $name_array[sizeof($name_array) - 1];

                $valide_filetype = array('jpg', 'jpeg', 'png');


                if ($file_size > 2097152) {
                    $errors[] = 'Desolé le fichier ne peut depasser 5M';
                }
                //var_dump($_FILES);exit;

                // $desired_dir='GALERIES/'.$data['titre'];

                $desired_dir =  __dir__.$liendossier;

                if(in_array(strtolower($file_type), $valide_filetype)){

                    if (is_dir($desired_dir) == false) {
                        mkdir("$desired_dir", 0755);        // Create directory if it does not exist
                    }
                    if (is_dir("$desired_dir/" . $file_name) == false) {
                        move_uploaded_file($file_tmp, "$desired_dir/" . $file_name);
                    } else {                                    // rename the file if another one exist
                        $new_dir = "$desired_dir/" . $file_name . time();
                        rename($file_tmp, $new_dir);
                    }

                    //Declaration et initialisation
                    $this->_entity_image = new Imagesmultipleimmo();

                    $this->_entity_image->setUrl('immobilier');
                    $this->_entity_image->setAlt($name_array[0]);
                    $this->_entity_image->setTitle($data['file_name']);
                    $this->_entity_image->setDateadd(new \Datetime());
                    //  var_dump($agence);exit;
                    $this->_entity_image->setBienimmo($agence);

                    $this->_em->persist($this->_entity_image);



                }

                else {

                    throw new NotFoundHttpException('Erreur survenue pendant le transfère des images !');
                }


            }
            if (empty($errors)) {
                $this->_em->flush();
                return true;

            }elseif(!empty($errors)){

                return false;
            }
        }
    }

    public function  uploadMultipleImagesChambre($liendossier, $agence, $chambre){
        if (isset($_FILES['files'])) {
            // var_dump($_FILES);exit;

            $errors = array();
            $data = array();

///            $data['name'] = htmlentities($_POST[$nameForm]["name"]);



            foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                $data['file_name'] = $file_name = $_FILES['files']['name'][$key];
                $data['file_size'] = $file_size = $_FILES['files']['size'][$key];
                $data['file_tmp'] = $file_tmp = $_FILES['files']['tmp_name'][$key];
                $data['file_type'] = $file_type = $_FILES['files']['type'][$key];
                $name_array = explode('.', $data['file_name']);
                $file_type  = $name_array[sizeof($name_array) - 1];

                $valide_filetype = array('jpg', 'jpeg', 'png');


                if ($file_size > 2097152) {
                    $errors[] = 'Desolé le fichier ne peut depasser 5M';
                }
                //var_dump($_FILES);exit;

                // $desired_dir='GALERIES/'.$data['titre'];

                $desired_dir =  __dir__.$liendossier;

                if(in_array(strtolower($file_type), $valide_filetype)){

                    if (is_dir($desired_dir) == false) {
                        mkdir("$desired_dir", 0755);        // Create directory if it does not exist
                    }
                    if (is_dir("$desired_dir/" . $file_name) == false) {
                        move_uploaded_file($file_tmp, "$desired_dir/" . $file_name);
                    } else {                                    // rename the file if another one exist
                        $new_dir = "$desired_dir/" . $file_name . time();
                        rename($file_tmp, $new_dir);
                    }

                    //Declaration et initialisation
                    $this->_entity_image = new Imagesmultiple();

                    $this->_entity_image->setUrl('chambres');
                    $this->_entity_image->setAlt($name_array[0]);
                    $this->_entity_image->setTitle($data['file_name']);
                    $this->_entity_image->setDateadd(new \Datetime());
                  //  var_dump($agence);exit;
                    $this->_entity_image->setAgence($agence);
                    $this->_entity_image->setChambre($chambre);
                    $this->_em->persist($this->_entity_image);
                    $this->_em->persist($agence);
                    $this->_em->persist($chambre);

                }

                else {

                   throw new NotFoundHttpException('Erreur survenue pendant le transfère des images !');
                }


            }
            if (empty($errors)) {
              $this->_em->flush();
                return true;

            }elseif(!empty($errors)){

                return false;
            }
        }
    }

    public  function  process(){

            return true;


    }
    public  function getForm(){

        return $this->_form;
    }
    //


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