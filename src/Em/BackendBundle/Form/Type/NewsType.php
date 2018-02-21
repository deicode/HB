<?php

namespace Em\BackendBundle\Form\Type;


use Em\FrontendBundle\Form\ImagesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('keywords')
            ->add('dateajout')
            ->add('dateedit')
            ->add('titre')
            ->add('slug')
            ->add('resume')
            ->add('contenus', 'ckeditor', array(
                'config' => array(
                    'filebrowserBrowseRoute' => 'elfinder',
                    'filebrowserBrowseRouteParameters' => []
                ),
            ))
            ->add('publish')
            ->add('Images', new ImagesType())
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Em\BackendBundle\Entity\News'
        ));
    }
}
