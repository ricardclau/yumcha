<?php

namespace Yumcha\Bundle\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class IcecreamCategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('titleCa')
            ->add('titleEs')
            ->add('titleEn')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yumcha\Bundle\WebsiteBundle\Entity\IcecreamCategory'
        ));
    }

    public function getName()
    {
        return 'yumcha_bundle_websitebundle_icecreamcategorytype';
    }
}
