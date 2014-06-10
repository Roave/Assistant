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

        // Fitering
        $eventManager->trigger($event::EVENT_FILTER, $event);

        // Intent matching
        $eventManager->trigger($event::EVENT_MATCH, $event);

        // Responding
        $eventManager->trigger($event::EVENT_RESPOND, $event);
    }

    public function addIntent(IntentInterface $intent, $priority = 1)
    {
        $this->getEventManager()->attachAggregate(new IntentListener($intent), $priority);
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
