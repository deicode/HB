<?php

namespace Em\FrontendBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

class Allfonction
{
    //Cette class va servir de verification
    // date
    //prix

    public function buffer($mois)
    {

        $databuffer = array(0);
        $months = array("Janvier", "Fevrier", "Mars", "Avril", "Mai", "Juin", "Juillet", "Aout", "Septembre", "Octobre", "Novembre", "Decembre");
        $monthsShort = array("Jan", "Fev", "Mar", "Avr", "Mai", "Jui", "Jui", "Aou", "Sep", "Oct", "Nov", "Dec");

        if (in_array($mois, $months) || in_array($mois, $monthsShort)) {


            //On recherche la position du mois
            $databuffer['key'] = array_search($mois, $months);


            if ($mois == "Avril" || $mois == "Avr" || $mois == 'Novembre' || $mois == 'Nov' || $mois == "Juin" || $mois == "Jui" ||  $mois == 'Septembre' || $mois == 'Sep') {

                $databuffer['mois'] = 30;
            }
            elseif ($mois == "Janvier" || $mois == "Jan" || $mois == 'Mars' || $mois == 'Mar'
                || $mois == "Mai" || $mois == "Mai" || $mois == 'Juillet' || $mois == 'Jui' || $mois == 'Aout'|| $mois == 'Aou'
                || $mois == 'Octobre'|| $mois == 'Oct'|| $mois == 'Decembre'|| $mois == 'Dec') {

                $databuffer['mois'] = 31;

            }elseif($mois == "Fevrier" || $mois == "Fev"){
                $databuffer['mois'] = 28;
            }else{
                return null;
            }


        }

        return $databuffer ;
    }
    public function verifFormatDate($format){


        //
         $dataarray = array();
        $styleform = explode(',', $format);
        //On definit 2 pour juste utiliser une date style Mars 10,Jeudi
        if(isset($styleform[0]) and count($styleform) == 2){

            $style = explode(' ',$styleform[0]);

            if(is_array($style)){
                $dataarray['jour'] = (int) $style[1];
                $dataarray['m'] = $this->buffer($style[0]) ;
                return $dataarray ;

            }else{
                return null;
            }

        }
    }
    public function verfiDateCalscul($datestart, $dateend){

        $start = $this->verifFormatDate($datestart);
        $end = $this->verifFormatDate($dateend);
        $jour = (int) date('d');
        $mois = (int) date('m');

        if($start['jour']  == $jour || $start['jour']  > $jour ||  $start['m']['key'] == $mois ){

            // var_dump($jour);exit;
            //si le nombre de jour final est inferieur
            if($end['jour'] < $start['jour']  ){
                $end['jour'] = $end['jour'] + $start['m']['mois'];
            }

            $nbsejour = $end['jour'] - $start['jour'];
             //  var_dump($end['jour']);exit;
            if( (int) $nbsejour > 0){
                return $nbsejour;
            }
        }else{

            return null;
        }
    }

    public function calculPrix($datestart, $dateend, $prix, $nbrechambre){
        $nbsejour = $this->verfiDateCalscul($datestart, $dateend);
        $newsprix = 0;

        if($nbsejour > 0){
            $newsprix =  $prix * $nbsejour * $nbrechambre ;

        }

        return $newsprix;

    }
}
