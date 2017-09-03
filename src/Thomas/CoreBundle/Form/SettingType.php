<?php

namespace Thomas\CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SettingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mail',       TextType::class, array('label' => 'Adresse mail'))
            ->add('phone',      TextType::class, array('label' => 'Numéro de téléphone'))
            ->add('address',    TextType::class, array('label' => 'Adresse'))
            ->add('image',      ProductImageType::class, array('label' => 'Logo')) 
            ->add('Sauvegarder',       SubmitType::class);
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Thomas\CoreBundle\Entity\Setting'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'thomas_corebundle_setting';
    }


}
