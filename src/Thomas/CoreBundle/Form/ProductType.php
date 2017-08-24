<?php

namespace Thomas\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('reference',  TextType::class)
            ->add('name',       TextType::class)
            ->add('price',      MoneyType::class)
            ->add('product_image',      ProductImageType::class) 
            // ->add('product_category', EntityType::class, array(
            //     'class'        => 'ThomasCoreBundle:ProductCategory',
            //     'choice_label' => 'name',
            // ))
            // ->add('brand', EntityType::class, array(
            //     'class'        => 'ThomasCoreBundle:Brand',
            //     'choice_label' => 'name',
            //     'multiple'     => false,
            // ))
            // ->add('editor', EntityType::class, array(
            //     'class'        => 'ThomasCoreBundle:Editor',
            //     'choice_label' => 'name',
            //     'multiple'     => false,
            // ))
            ->add('system', EntityType::class, array(
                'class'        => 'ThomasCoreBundle:System',
                'choice_label' => 'name',
                'multiple'     => false,
            ))
            ->add('save',       SubmitType::class);
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
