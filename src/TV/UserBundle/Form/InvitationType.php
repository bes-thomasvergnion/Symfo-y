<?php

namespace TV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use TV\UserBundle\Repository\BandRepository;

class InvitationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $user = $this->user = $options['user'];
        $receiver = $this->user = $options['receiver'];
        
        
        $builder
            ->add('band', EntityType::class, array(
                'class' => 'TVUserBundle:Band',
                'query_builder' => function(BandRepository $repository) use($user, $receiver) {
                return $repository->getLikeQueryBuilder($user, $receiver);
                },
                'choice_label' => 'name',
            ))
            
            ->add('save', SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'TV\UserBundle\Entity\Invitation',
            'user' => NULL,
            'receiver' => NULL,
        ));
    }
}
