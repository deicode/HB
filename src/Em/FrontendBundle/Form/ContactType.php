<?php

namespace Em\FrontendBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nomprenoms')
            ->add('email', 'email')
            ->add('phone')
            ->add('message','textarea')
            ->add('sujet','choice', array(
                'choices' => array(
                    "Reservation" => "Réservation",
                    "Achat" => "Achat",
                ))
            );
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Em\FrontendBundle\Entity\Contact'
        ));
    }
}
