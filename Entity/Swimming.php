<?php

namespace ScoutEvent\SwimmingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Swimming
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Swimming
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="ScoutEvent\DataBundle\Entity\Participant")
     * @ORM\JoinColumn(name="participant_id", referencedColumnName="id")
     */
    private $participant;

    /**
     * @var boolean
     *
     * @ORM\Column(name="canSwim", type="boolean")
     */
    private $canSwim;

    /**
     * @param Participant $participant
     */
    public function __construct($participant)
    {
        $this->participant = $participant;
    }

    /**
     * @return Participant
     */
    public function getParticipant()
    {
        return $this->participant;
    }

    /**
     * Set canSwim
     *
     * @param boolean $canSwim
     * @return Swimming
     */
    public function setCanSwim($canSwim)
    {
        $this->canSwim = $canSwim;

        return $this;
    }

    /**
     * Get canSwim
     *
     * @return boolean 
     */
    public function getCanSwim()
    {
        return $this->canSwim;
    }
}
