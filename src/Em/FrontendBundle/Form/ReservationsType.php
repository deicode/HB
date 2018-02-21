<?php

namespace Em\FrontendBundle\Form;

use Em\BackendBundle\Entity\Chambre;
use Em\BackendBundle\Form\Type\ChambreType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReservationsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prenoms')
            ->add('phone')
            ->add('email','email')
            ->add('modepayement', 'choice', array(
                'choices' => array(
                    "Payer_a_hotel" => "Payer à l'hôtel",
                    "Orange_Money" => "Orange Money",
                    "MTN_Mobile_Money" => "MTN Mobile Money",
                    "Moov_Money" => "Moov Money",

                ),

                'expanded' => true,
                'multiple' => false,
                'required' => true,
                )


            )
            //->add('prixtotal')
            ->add('datearrivee')
            ->add('datedepart')
            //->add('nbadulte')
            //->add('nbenfant')
            //->add('nbjour')
            ->add('dateadd', 'datetime')
            ->add('numeroreservation')
            //->add('status')
            ->add('proprietaire')
            ->add('typeaction','choice', array(
                'choices' => array(
                    "Reservation" => "Réservation",
                    "Achat" => "Achat",
                ))
            )
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Em\FrontendBundle\Entity\Reservations'
        ));
    }



}
