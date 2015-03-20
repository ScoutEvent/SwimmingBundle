<?php

namespace ScoutEvent\SwimmingBundle\Form;

use ScoutEvent\SwimmingBundle\Form\Type\HealthFormSwimmingType;
use ScoutEvent\SwimmingBundle\Entity\Swimming;
use ScoutEvent\ManagementBundle\Form\HealthFormAdditionalStepProvider;

class SwimmingStepProvider extends HealthFormAdditionalStepProvider
{

    public $em;

    public function __construct($em)
    {
        $this->em = $em;
    }

    public function getSteps()
    {
        return array(
            array(
                'label' => 'Swimming',
                'type' => new HealthFormSwimmingType(),
                'skip' => function($estimatedCurrentStepNumber, $flow) {
                    $participant = $flow->getFormData()->getParticipant();
                    return $this->isSwimming($participant);
                }
            )
        );
    }
    
    private function isSwimming($participant)
    {
        if (!$participant->getYoungPerson()) return true;
        $event = $participant->getEvent();
        $swimming = $this->em
                ->getRepository('ScoutEventSwimmingBundle:EventSwimming')
                ->findOneBy(array('event' => $event));
        if ($swimming == null) return true;
        return !$swimming->isSwimming();
    }
    
    public function additionalProcess($flow, $form, $healthFormEntity)
    {
        $participant = $healthFormEntity->getParticipant();
        if ($this->isSwimming($participant))
        {
            return;
        }

        $swimming = $this->em->getRepository('ScoutEventSwimmingBundle:Swimming')
                ->findOneBy(array('participant' => $participant));
        $new = false;
        if ($swimming == null)
        {
            $swimming = new Swimming($participant);
            $new = true;
        }
        print_r($flow->getDataManager()->load($flow));

        /*
        $swimming->setCanSwim($form->get('swimming')->getData());
        */
        
        if ($new)
        {
            $this->em->persist($swimming);
        }
    }

}
