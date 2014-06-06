<?php
namespace Roave\Assistant\Brain;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class AggregateBrain implements BrainInterface, EventManagerAwareInterface
{
    use EventManagerAwareTrait;

    public function addBrain(BrainInterface $brain, $priority = 1, $readOnly = false)
    {
        $this->getEventManager()->attachAggregate(new BrainListener($brain, $readOnly), $priority);
    }

    public function store($key, $value)
    {
        $params = compact('key', 'value');
        $result = $this->getEventManager()->trigger('store', $this, $params);

        return $result->last(); // eh..?
    }

    public function fetch($key)
    {
        $params = compact('key');
        $result = $this->getEventManager()->trigger('fetch', $this, $params, function($value) {
            return $value !== null;
        });

        return $result->last();
    }
}
