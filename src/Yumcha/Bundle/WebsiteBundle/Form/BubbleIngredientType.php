<?php

namespace Yumcha\Bundle\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class BubbleIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('titleCa')
            ->add('titleEs')
            ->add('titleEn')
            ->add('category')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yumcha\Bundle\WebsiteBundle\Entity\BubbleIngredient'
        ));
    }

    public function getName()
    {
        return 'yumcha_bundle_websitebundle_bubbleingredienttype';
    }
}
