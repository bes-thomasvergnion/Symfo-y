<?php
// src/TV/UserBundle/Form/BandEditType.php

namespace TV\UserBundle\Form;

use Symfony\Component\Form\AbstractType;

class BandEditType extends AbstractType
{
  public function getParent()
  {
    return BandType::class;
  }
}
