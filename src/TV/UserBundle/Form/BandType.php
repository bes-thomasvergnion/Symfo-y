<?php

namespace TV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use TV\FindyourbandBundle\Form\SelectType;

class BandType extends AbstractType
{
    public function getParent()
    {
        return SelectType::class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->remove('instrument')
            ->add('name', TextType::class)
            ->add('video', TextType::class, array('required' => false))
            ->add('content', TextareaType::class)
            ->add('image', ImageType::class, array('required' => false))
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TV\UserBundle\Entity\Band'
        ));
    }
}
