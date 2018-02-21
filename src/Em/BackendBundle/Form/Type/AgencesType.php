<?php

namespace Em\BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
class AgencesType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('title')
            ->add('grade','choice', array(
                'choices' => array('' => '-------Selectionnez les étoiles --------' ,'5' => '5 Etoiles','4' =>'4 Etoiles',
                    '3' => '3 Etoiles','2' => '2 Etoiles','1' => '1 Etoiles',
                ),))
            ->add('status','choice', array(
                'choices' => array('' => '-------Selectionnez --------' ,'Fantastique' => 'Fantastique','Excellent' =>'Excellent',
                    'Très bien' => 'Très bien','Bien' => 'Bien','Passable' => 'Passable','Mediocre' => 'Mediocre',
                ),))
            ->add('caracteristique','choice', array(
                'choices' => array('Hotel' => 'Hôtel'

                ),))

            ->add('description','textarea')
            ->add('telephone')
            ->add('urlmap')
            ->add('wifi')
            ->add('piscine')
            ->add('climatisation')
            ->add('restaurant')
            ->add('servicechambre')
            ->add('petitdejeuner')
            ->add('nightclub')
            ->add('massage')
            ->add('gym')
            ->add('casino')
            ->add('adresse')
            ->add('prixinit')
            ->add('locked')
            ->add('ville')
            ->add('proprietaire')
            ->add('pourcentagecommercial')
            ->add('pays', CountryType::class)
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Em\BackendBundle\Entity\Agences'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'agences';
    }

}
