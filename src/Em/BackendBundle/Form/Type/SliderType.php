<?php

namespace Em\BackendBundle\Form\Type;

use Em\FrontendBundle\Entity\Images;
use Em\FrontendBundle\Form\ImagesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SliderType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text' ,array ('attr' => array( 'required' => false)))
            ->add('prix', 'text',  array ('attr' => array( 'required' => false)))
            ->add('Images', new ImagesType())
            ->add('statusimmo','entity',
                array ('label' => 'NomDuLabel',
                    'class' => 'EmBackendBundle:Statusimmo',
                    'property' => 'libelle',
                    'required' => false))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Em\BackendBundle\Entity\Slider'
        ));
    }

    public function  getName(){
     return 'slider_form';
   }

}
