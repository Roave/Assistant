<?php
namespace Roave\Assistant;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

class IntentListener extends AbstractListenerAggregate
{
    protected $intent;

    public function __construct(IntentInterface $intent)
    {
        $this->intent = $intent;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach(AssistantEvent::EVENT_MATCH, array($this, 'onMatch'), $priority);
    }

    public function onMatch($e)
    {
        $input = $e->getFilteredInput();

        $match = $this->intent->match($input);

        if (!$match) {
            return;
        }

        $e->stopPropagation($this->intent->isFinal());

        $e->addIntentMatch($this->intent);
    }
}
