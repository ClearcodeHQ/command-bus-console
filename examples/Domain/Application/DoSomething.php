<?php

namespace examples\Domain\Application;

final class DoSomething
{
    /** @var string */
    private $theThing;

    /** @var int */
    private $numberOfTimes;

    /** @var \DateTime */
    private $startingOn;

    /**
     * @param string    $theThing
     * @param int       $numberOfTimes
     * @param \DateTime $startingOn
     */
    public function __construct($theThing, $numberOfTimes, $startingOn)
    {
        $this->theThing = $theThing;
        $this->numberOfTimes = $numberOfTimes;
        $this->startingOn = $startingOn;
    }
}
