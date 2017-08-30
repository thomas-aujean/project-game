<?php

namespace Thomas\BackOfficeBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SearchType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array(
                'required'     => false,
                'label'        => 'Nom'
            ))
            ->add('productCategory', EntityType::class, array(
                'class'        => 'ThomasCoreBundle:ProductCategory',
                'choice_label' => 'name',
                'multiple'     => false,
                'required'     => false,
                'label'        => 'Categorie'
            ))
            ->add('brand', EntityType::class, array(
                'class'        => 'ThomasCoreBundle:Brand',
                'choice_label' => 'name',
                'multiple'     => false,
                'required'     => false,
                'label'        => 'Marque'
            ))
            ->add('system', EntityType::class, array(
                'class'        => 'ThomasCoreBundle:System',
                'choice_label' => 'name',
                'multiple'     => false,
                'required'     => false,
                'label'        => 'Console'
            ))

            ->add('search',       SubmitType::class);
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Thomas\CoreBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'thomas_corebundle_product';
    }


}
