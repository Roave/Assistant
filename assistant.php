<?php
include 'vendor/autoload.php';

$app = Zend\Mvc\Application::init(require 'config/application.config.php');

$sm = $app->getServiceManager();

$assistant = $app->getServiceManager()->get('roave-assistant');
$brain = $sm->get('roave-assistant-brain-aggregate');
$value = $brain->fetch('global.law1');
var_dump($value);exit;

$input = 'My name is Evan.';
$assistant->run($input);

var_dump($assistant->getAssistantEvent()->getMatchedIntents());
