<?php
// src/TV/UserBundle/Form/BandEditType.php

namespace TV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class BandEditType extends AbstractType
{
  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    
  }

  public function getParent()
  {
    return BandType::class;
  }
}
