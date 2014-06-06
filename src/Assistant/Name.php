<?php

class Intent
{
    protected $name = 'set_user_name';

    protected $alts = [
        '@okay' => ['alright', 'okay', 'kay'],
    ];

    protected $expressions = [
        'my name is :name',
        'call me :name',
        'i am :name',
    ];

    protected $responses = [
        'okay, i\'ll call you @user_name',
        'okay, @user_name it is',
    ];

    public function respond($expression)
    {
        $name = $expression->get('name');

