<?php
namespace Roave\Assistant\TheRules;

class Module
{
    protected $config = [
        'roave_assistant_brain' => [
            'fallback' => [
                'global.law1' => 'A robot may not injure a human being or, through inaction, allow a human being to come to harm.',
                'global.law2' => 'A robot must obey the orders given to it by human beings, except where such orders would conflict with the First Law.',
                'global.law3' => 'A robot must protect its own existence as long as such protection does not conflict with the First or Second Law.',

            ],
            //'override' => [],
        ],
        'roave_assistant_intents' => [
            'ask_rules' => [
                'expressions' => [
                    '(what are|tell me) the (3 |three )?(robot )?(rules|laws)( for robots)?',
                ],
                'responses' => [
                    '1. @global.law1 2. @global.law2 3. @global.law3'
                ],
            ],
            'ask_specific_rule' => [
                'expressions' => [
                    '(what is|tell me) the :nth[type] (law|rule)( of robotics)?',
                ],
                'responses' => [
                    'The :nth law of robitics is @global.law$nth',
                ],
            ],
        ],
    ];

    public function getConfig()
    {
        return $this->config;
    }
}
