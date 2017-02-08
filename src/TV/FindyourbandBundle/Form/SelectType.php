<?php

namespace TV\FindyourbandBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class SelectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('instrument', EntityType::class, array(
                'class' => 'TVFindyourbandBundle:Instrument',
                'placeholder' => '--',
                'required'  => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
            ))
            ->add('genre', EntityType::class, array(
                'class' => 'TVFindyourbandBundle:Genre',
                'placeholder' => '--',
                'required'  => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
            ))
            ->add('province', EntityType::class, array(
                'class' => 'TVFindyourbandBundle:Province',
                'placeholder' => '--',
                'required'  => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.name', 'ASC');
                },
                'choice_label' => 'name',
            ))
            ->add('level', EntityType::class, array(
                'class' => 'TVFindyourbandBundle:Level',
                'placeholder' => '--',
                'required'  => false,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->orderBy('u.id', 'ASC');
                },
                'choice_label' => 'name',
            ))
            ->add('save', SubmitType::class, array(
                'attr' => array('class' => 'save'),
            ))
        ;
    }
}
