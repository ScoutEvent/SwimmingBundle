<?php

namespace ScoutEvent\SwimmingBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Swimming
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class EventSwimming
{
    /**
     * @ORM\Id
     * @ORM\OneToOne(targetEntity="ScoutEvent\DataBundle\Entity\Event")
     * @ORM\JoinColumn(name="event_id", referencedColumnName="id", nullable=true, onDelete="cascade")
     */
    private $event;

    /**
     * @var boolean
     *
     * @ORM\Column(name="swimming", type="boolean")
     */
    private $swimming;

    /**
     * @param Event $event
     */
    public function __construct($event)
    {
        $this->event = $event;
    }

    /**
     * @return Event
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * Set swimming
     *
     * @param boolean $swimming
     * @return EventSwimming
     */
    public function setSwimming($swimming)
    {
        $this->swimming = $swimming;

        return $this;
    }

    /**
     * Get swimming
     *
     * @return boolean 
     */
    public function isSwimming()
    {
        return $this->swimming;
    }
}
