<?php
return [
    'service_manager' => [
        'factories' => [
            'roave-assistant' => 'Roave\Assistant\AssistantFactory',
            'roave-assistant-intents' => 'Roave\Assistant\IntentFactory',
        ],
        'invokables' => [
            'roave-assistant-plugin-manager' => 'Roave\Assistant\PluginManager',
        ],
    ],
];
