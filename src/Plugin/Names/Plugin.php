<?php
namespace Roave\Assistant\Plugin\Names;

use Roave\Assistant\Plugin\Names\Intent;
use Roave\Assistant;

class Plugin implements Assistant\IntentProviderInterface
{
    protected $intents = [
        'set_user_name' => [
            'expressions' => [
                'my name is @user_name',
                '(please) call me @user_name (please)',
                'i am @user_name',
            ],

    ];
    public function init($assistant)
    {
        $assistant->attachIntent(new Intent\SetUserName);
    }
}
