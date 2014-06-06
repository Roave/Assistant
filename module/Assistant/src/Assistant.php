<?php
namespace Roave\Assistant;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;
use Zend\EventManager\EventManager;

class Assistant implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    protected $event;

    public function run($input)
    {
        $this->reset(); // prepare for next request

        $eventManager = $this->getEventManager();
        $event        = $this->getAssistantEvent();
        $event->setRawInput($input);
        $event->setAssistant($this);

        // Fitering (+ intent matching?)
        $eventManager->trigger($event::EVENT_PARSE, $event);

        // Intent matching?
        $eventManager->trigger($event::EVENT_PROCESS, $event);

        // Responding
        $eventManager->trigger($event::EVENT_RESPOND, $event);
    }

    public function setAssistantEvent(AssistantEvent $event)
    {
        $this->event = $event;
    }

    public function getAssistantEvent()
    {
        if (!$this->event) {
            $this->setAssistantEvent(new AssistantEvent);
        }

        return $this->event;
    }

    protected function reset()
    {
        $this->event = null;
    }
}
