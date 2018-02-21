<?php

namespace Em\BackendBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('phone')
            ->add('adresse')
            ->add('ville')
            ->add('dateinscrit', 'datetime')
            ->add('pays')
            ->add('email', 'email')
            ->add('username')
            ->add('prenoms')
            ->add('roles', 'choice', array(
                'choices' => array('' => '-------Selectionnez le rôle--------', 'Superviseur' => 'Superviseur', 'Admin' => 'Administrateur',
                ),))

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Em\BackendBundle\Entity\User'
        ));
    }
}
