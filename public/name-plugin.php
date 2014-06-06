<?php

$intent = new Intent('set_user_name');

/**
 * @variable_name = sets that variable to a new value in the brain
 * :variable_name = does not store the value anywhere
 *
 */
$intent->addExpressions([
    'my name is @user_name',
    '(please) call me @user_name (please)',
    'i am @user_name',
]);

$intent->addResponses([
    'okay, i\'ll call you @user_name',
    'okay, @user_name it is',
]);


$assistant = new Assistant('user_id');
$response = $assistant->dispatch('My name is Evan.');




