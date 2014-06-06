<?php
return [
    'service_manager' => [
        'factories' => [
            'roave-assistant' => 'Roave\Assistant\AssistantFactory',
        ],
        'invokables' => [
            'roave-assistant-plugin-manager' => 'Roave\Assistant\PluginManager',
        ],
    ],
];
