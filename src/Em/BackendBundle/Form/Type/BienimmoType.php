<?php

namespace Em\BackendBundle\Form\Type;

use Em\FrontendBundle\Form\ImagesType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Country;

use Symfony\Component\Form\Extension\Core\Type\CountryType;

class BienimmoType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('adresse')
            ->add('libelle')
            ->add('nomprenoms')
            ->add('telephone')
            ->add('description')
            ->add('prix')
            ->add('recommander')
            ->add('etage')
            ->add('anneeconstruction')
            ->add('surfacehabitable')
            ->add('surfaceterrain')
            ->add('nbrepiece')
            ->add('jardin', ChoiceType::class, array(
                'choices' => array(
                    false => 'Non',
                    true => 'Oui',
                ),))
            ->add('piscine', ChoiceType::class, array(
                'choices' => array(
                    false => 'Non',
                    true => 'Oui',
                ),))
            ->add('balcon', ChoiceType::class, array(
                'choices' => array(
                    false => 'Non',
                    true => 'Oui',
                ),))
            ->add('terrasse', ChoiceType::class, array(
                'choices' => array(
                    false => 'Non',
                    true => 'Oui',
                ),))
            ->add('parking', ChoiceType::class, array(
                'choices' => array(
                    false => 'Non',
                    true => 'Oui',
                ),))
            ->add('garage', ChoiceType::class, array(
                'choices' => array(
                    false => 'Non',
                    true => 'Oui',
                ),))
            ->add('cave', ChoiceType::class, array(
                'choices' => array(
                    false => 'Non',
                    true => 'Oui',
                ),))
            ->add('ascenseur', ChoiceType::class, array(
                'choices' => array(
                    false => 'Non',
                    true => 'Oui',
                ),))
            ->add('urlmap')
            ->add('locked')
            ->add('reference')
            ->add('pays', CountryType::class)
            ->add('ville')

            ->add('statusimmo','entity',
                array ('label' => 'NomDuLabel',
                    'class' => 'EmBackendBundle:Statusimmo',
                    'property' => 'libelle',
                    'required' => true))
            ->add('typeimmo','entity',
                array ('label' => 'NomDuLabel',
                    'class' => 'EmBackendBundle:Typeimmo',
                    'property' => 'libelle',
                    'required' => true))
            ->add('etatimmo','entity',
                array ('label' => 'NomDuLabel',
                    'class' => 'EmBackendBundle:Etatimmo',
                    'property' => 'libelle',
                    'required' => true))
            ->add('typesaison','entity',
            array ('label' => 'NomDuLabel',
                'class' => 'EmBackendBundle:Typesaison',
                'property' => 'libelle',
                'required' => true));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Em\BackendBundle\Entity\Bienimmo'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'em_backendbundle_bienimmo';
    }


}
