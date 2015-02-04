<?php

namespace ScoutEvent\SwimmingBundle\Form;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;
use ScoutEvent\SwimmingBundle\Entity\EventSwimming;
use ScoutEvent\ManagementBundle\Form\EventAdditionalStepProvider;

class SwimmingEventProvider extends EventAdditionalStepProvider
{
    private $em;
    
    public function __construct($em)
    {
        $this->em = $em;
    }

    public function addAdditional(FormBuilderInterface $builder)
    {
        $builder->add('swimming', 'checkbox', array(
            'label' => 'Will there be swimming at this event?',
            'required' => false,
            'mapped' => false
        ));

        $builder->addEventListener(FormEvents::POST_SET_DATA, function (FormEvent $event) {
            $eventEntity = $event->getData();
            $form = $event->getForm();

            $swimming = $this->em
                    ->getRepository('ScoutEventSwimmingBundle:EventSwimming')
                    ->findOneBy(array('event' => $eventEntity));
            if ($swimming != null && $swimming->isSwimming())
            {
                $form->get('swimming')->setData(true);
            }
        });
    }
    
    public function remove($event)
    {
        $swimming = $this->em
                ->getRepository('ScoutEventSwimmingBundle:EventSwimming')
                ->findOneBy(array('event' => $event));
        if ($swimming != null)
        {
            $this->em->remove($swimming);
        }
    }
    
    public function persist($form, $event)
    {
        $isSwimming = $form->get('swimming')->getData();
        
        $swimming = $this->em
                ->getRepository('ScoutEventSwimmingBundle:EventSwimming')
                ->findOneBy(array('event' => $event));
        if ($swimming == null)
        {
            if ($isSwimming)
            {
                $swimming = new EventSwimming($event);
                $swimming->setSwimming(true);
                $this->em->persist($swimming);
            }
        }
        else
        {
            if ($isSwimming)
            {
                if (!$swimming->isSwimming())
                {
                    $swimming->setSwimming(true);
                }
            }
            else
            {
                $this->em->remove($swimming);
            }
        }
    }

}
