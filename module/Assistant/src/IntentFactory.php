<?php
namespace Roave\Assistant;

class IntentFactory
{
    public function __invoke($serviceLocator)
    {
        $config = $serviceLocator->has('Config') ? $serviceLocator->get('Config') : [];
        $config = isset($config['roave_assistant_intents']) ? $config['roave_assistant_intents'] : [];

        $assistant = $serviceLocator->get('roave-assistant');

        $intents = [];

        foreach ($config as $intentName => $intentConfig) {
            $expressions = isset($intentConfig['expressions']) ? $intentConfig['expressions'] : [];
            $final = isset($intentConfig['final']) ? $intentConfig['final'] : false;
            $intent = new Intent($intentName);
            // Note: addExpressions() isn't part of the IntentInterface
            $intent->addExpressions($expressions);
            $intent->setFinal($final);
            $assistant->addIntent($intent);
            $intents[] = $intent;
        }

        return $intents;
    }
}
