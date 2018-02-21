<?php
/**
 * Created by PhpStorm.
 * User: stebio
 * Date: 02/03/16
 * Time: 16:12
 */

namespace Em\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class HotelRechercheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('motcle', 'text', array('label' => 'Mot-clé'));
    }

    public function getName()
    {
        return 'hotelrecherche';
    }
}