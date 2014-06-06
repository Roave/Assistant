<?php
namespace Roave\Assistant\FavoritesPlugin;

class Module
{
    protected $config = [
        'roave_assistant_intents' => [
            'set_user_favorite' => [
                'expressions' => [
                    'my favorite :user_favorite_key is :user_favorite_value' // dynamic?
                ],
            ],
            'get_user_favorite' => [
                'expressions' => [
                    'what is my favorite :user_favorite_key',
                    'tell me my favorite :user_favorite_key'
                ],
            ],
        ],

    ];

    public function getConfig()
    {
        return $this->config;
    }
}
