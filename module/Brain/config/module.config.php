<?php
return [
    'roave_assistant_brain' => [
        'fallback' => [],
        'override' => [],
    ],
    'service_manager' => [
        'aliases' => [
            'roave-assistant-brain' => 'roave-assistant-brain-memory',
        ],
        'factories' => [
            'roave-assistant-brain-aggregate' => 'Roave\Assistant\Brain\BrainFactory',
        ],
        'invokables' => [
            'roave-assistant-brain-memory' => 'Roave\Assistant\Brain\MemoryBrain',
        ],
    ],
];
