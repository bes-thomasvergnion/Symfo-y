<?php

namespace TV\FindyourbandBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchType extends AbstractType
{
    public function getParent()
    {
        return SelectType::class;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' =>  'TV\FindyourbandBundle\Entity\Search',
            'attr'=>[
                'id'=>'myForm'
            ]
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'tv_findyourbandbundle_search';
    }


}
