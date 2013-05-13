<?php

namespace Yumcha\Bundle\WebsiteBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TextType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('textCa', 'textarea', array(
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'simple' // simple, advanced, bbcode
                )
            ))
            ->add('textEs', 'textarea', array(
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'simple' // simple, advanced, bbcode
                )
            ))
            ->add('textEn', 'textarea', array(
                'attr' => array(
                    'class' => 'tinymce',
                    'data-theme' => 'simple' // simple, advanced, bbcode
                )
            ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Yumcha\Bundle\WebsiteBundle\Entity\Text'
        ));
    }

    public function getName()
    {
        return 'yumcha_bundle_websitebundle_texttype';
    }
}
