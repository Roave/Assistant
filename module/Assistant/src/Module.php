<?php
namespace Roave\Assistant;

class Module
{
    public function init($moduleManager)
    {
        $sm = $moduleManager->getEvent()->getParam('ServiceManager');
        $serviceListener = $sm->get('ServiceListener');
        $serviceListener->addServiceManager(
            'roave-assistant-plugin-manager',
            'roave_assistant_plugins',
            'Roave\Assistant\Feature\AssistantPluginProviderInterface',
            'getAssistantPluginConfig'
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    // @todo split this off to a class
    public function onBootstrap($e)
    {
        $sm = $e->getApplication()->getServiceManager();
        $config = $sm->get('Config');
        if (!isset($config['roave_assistant_intents'])) {
            return;
        }

        $assistant = $sm->get('roave-assistant');

        foreach ($config['roave_assistant_intents'] as $name => $intentConfig) {

        }
    }
}
