<?php
namespace Roave\Assistant\Brain;

use Zend\EventManager\AbstractListenerAggregate;
use Zend\EventManager\EventManagerInterface;

class BrainListener extends AbstractListenerAggregate
{
    protected $brain;
    protected $readOnly = false;

    public function __construct(BrainInterface $brain, $readOnly = false)
    {
        $this->brain    = $brain;
        $this->readOnly = $readOnly;
    }

    public function attach(EventManagerInterface $events, $priority = 1)
    {
        $this->listeners[] = $events->attach('fetch', array($this, 'onFetch'), $priority);

        if (!$this->readOnly) {
            $this->listeners[] = $events->attach('store', array($this, 'onStore'), $priority);
        }
    }

    public function onFetch($e)
    {
        $params = $e->getParams();
        $key    = $params['key'];

        return $this->brain->fetch($key);
    }

    public function onStore($e)
    {
        $params = $e->getParams();
        $key    = $params['key'];
        $value  = $params['value'];

        return $this->brain->store($key, $value);
    }
}
