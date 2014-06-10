<?php
namespace Roave\Assistant;

use Zend\EventManager\Event;

class AssistantEvent extends Event
{
    const EVENT_FILTER  = 'filter';
    const EVENT_MATCH   = 'match';
    const EVENT_RESPOND = 'respond';

    protected $rawInput;

    protected $filteredInput;

    protected $assistant;

    protected $matchedIntents = [];

    /**
     * @return rawInput
     */
    public function getRawInput()
    {
        return $this->rawInput;
    }

    /**
     * @param $rawInput
     * @return self
     */
    public function setRawInput($rawInput, $resetFiltered = true)
    {
        $this->rawInput = $rawInput;

        if ($resetFiltered) {
            $this->setFilteredInput($rawInput);
        }

        return $this;
    }

    /**
     * @return filteredInput
     */
    public function getFilteredInput()
    {
        return $this->filteredInput;
    }

    /**
     * @param $filteredInput
     * @return self
     */
    public function setFilteredInput($filteredInput)
    {
        $this->filteredInput = $filteredInput;
        return $this;
    }

    /**
     * @return assistant
     */
    public function getAssistant()
    {
        return $this->assistant;
    }

    /**
     * @param $assistant
     * @return self
     */
    public function setAssistant(Assistant $assistant)
    {
        $this->assistant = $assistant;
        return $this;
    }

    public function addIntentMatch(IntentInterface $intent)
    {
        $this->matchedIntents[$intent->getName()] = $intent;
    }

    public function getMatchedIntents()
    {
        return $this->matchedIntents;
    }
}
