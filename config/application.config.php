<?php
return [
    'modules' => [
        'Roave\Assistant',
        'Roave\Assistant\Brain',
        'Roave\Assistant\TheRules',
        'Roave\Assistant\NamePlugin',
    ],
    'module_listener_options' => [
        'config_glob_paths' => [
            'config/autoload/{,*.}{global,local}.php',
        ],
    ],
];
