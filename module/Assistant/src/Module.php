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

    public function onBootstrap($e)
    {
        // attach intents
        $sm = $e->getApplication()->getServiceManager();
        $assistant = $sm->get('roave-assistant-intents');
    }
}
