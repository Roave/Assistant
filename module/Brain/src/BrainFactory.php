<?php
namespace Roave\Assistant\Brain;

class BrainFactory
{
    public function __invoke($sm)
    {
        $aggregateBrain = new AggregateBrain;

        $config = $sm->get('Config');

        $primaryBrain  = $sm->get('roave-assistant-brain');
        $fallbackBrain = new MemoryBrain($config['roave_assistant_brain']['fallback']);
        $overrideBrain = new MemoryBrain($config['roave_assistant_brain']['override']);

        $aggregateBrain->addBrain($primaryBrain);
        $aggregateBrain->addBrain($fallbackBrain, -100);
        $aggregateBrain->addBrain($overrideBrain, 100);

        return $aggregateBrain;
    }
}
