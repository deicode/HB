<?php

namespace Em\BackendBundle\Form\Type;

use Em\FrontendBundle\Form\ImagesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PubType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('dateadd', 'datetime')
            ->add('datestart', 'date')
            ->add('dateend', 'date')
            ->add('pourcentage')
            ->add('prixstart')
            ->add('Images', new ImagesType())
            ->add('agences','entity',
                array ('label' => 'NomDuLabel',
                    'class' => 'EmBackendBundle:Agences',
                    'property' => 'nom'
                ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Em\BackendBundle\Entity\Pub'
        ));
    }
}
