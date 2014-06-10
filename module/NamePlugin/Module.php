<?php
namespace Roave\Assistant\NamePlugin;

class Module
{
    protected $config = [
        'roave_assistant_intents' => [
            'set_user_name' => [
                'expressions' => [
                    'my name is (.*)+',
                    'my name is @user.name',
                    '(please )?call me @user.name( please)?',
                    'i am @user.name',
                ],
                'responses' => [
                    'Okay, I\'ll call you @user.name.',
                    'Okay, @user.name it is.',
                ],
            ],
            'get_user_name' => [
                'expressions' => [
                    'what is my name'
                ],
                'respones' => [
                    'Your name is @user.name.'
                ],
            ],
        ],

    ];

    public function getConfig()
    {
        return $this->config;
    }
}
