<?php

namespace Em\BackendBundle\Form\Type;

use Em\BackendBundle\Entity\Agences;
use Em\FrontendBundle\Form\ImagesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChambreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typelit')
            ->add('capacitemax')
            ->add('dateadd', 'datetime')
            ->add('totalchambre')
            ->add('prixinit')
            ->add('prixchambre')
            ->add('pourcentagesolde')
            ->add('description')
            ->add('typechambre','choice', array(
                'choices' => array('' => '-------Selectionnez --------' ,'Chambre Simple' => 'Chambre Simple',
                    'Chambre Standard' =>'Chambre Standard',
                    'Mini Suite' => 'Mini Suite','Suite Junior' => 'Suite Junior',
                    'Suite Senior' => 'Suite Senior', 'Suite Executive' => 'Suite Executive',
                ),))
            ->add('climatisation')
            ->add('douche')
            ->add('tvlcplasma')
            ->add('baignoire')
            ->add('cuisine')
            ->add('salon')
            ->add('refrigerateur')
            ->add('bureau')
            ->add('filmalademande')
            ->add('telephone')
            ->add('tv')
            ->add('images', new ImagesType())
            ->add('minibar')
            ->add('locked')

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Em\BackendBundle\Entity\Chambre'
        ));
    }
}
