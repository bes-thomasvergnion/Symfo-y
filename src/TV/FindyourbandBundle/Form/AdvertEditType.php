<?php

namespace TV\FindyourbandBundle\Form;

use Symfony\Component\Form\AbstractType;

class AdvertEditType extends AbstractType
{
  public function getParent()
  {
    return AdvertType::class;
  }
}
