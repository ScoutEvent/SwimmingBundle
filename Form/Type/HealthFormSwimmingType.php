<?php

namespace ScoutEvent\SwimmingBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class HealthFormSwimmingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('swimming', 'checkbox', array(
            'label' => 'Can this young person swim 50m unaided?',
            'required' => false,
            'mapped' => false
        ));
    }

    public function getName()
    {
        return 'healthFormSwimming';
    }
}
