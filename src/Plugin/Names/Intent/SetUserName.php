<?php
namespace Roave\Assistant\Plugin\Names\Intent;

use Roave\Assistant\Intent;

class SetUserName extends Intent
{
    protected $name = 'set_user_name';

    protected $expressions = [
        'my name is @user_name',
        '(please) call me @user_name (please)',
        'i am @user_name',
    ];

    protected $responses = [
        'okay, i\'ll call you @user_name',
        'okay, @user_name it is',
    ];


    /**
     *  @TODO: Something like this... hint on how it could randomly inquire for
     *  this info if it doesn't have it yet, and it is in conversational mode
     *  or something...
     *
     *  protected $inquire = [
     *      'what is your name?',
     *  ];
     */
}
