<?php
namespace Roave\Assistant;

class Intent implements IntentInterface
{
    protected $name;

    protected $expressions = [];

    protected $responses = [];

    public function __construct($name = null)
    {
        if ($name) {
            $this->setName($name);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function addExpressions(array $expressions)
    {
        $this->expressions = array_merge($this->expressions, $expressions);
    }

    public function matches($string)
    {
        foreach ($this->expressions as $expression) {
            if (preg_match($expression, $string, $matches)) {
                return true;
            }
        }

        return false;
    }

    public function attach(Assistant $assistant)
    {
        $assistant->getEventManager()->attach(AssistantEvent::EVENT_PROCESS, array($this, 'onParse'));
    }

    public function onParse(AssistantEvent $event)
    {
        if (!$this->matches($event->getFilteredInput())) {
            return;
        }

        $event->addIntentMatch($this);
    }
}
