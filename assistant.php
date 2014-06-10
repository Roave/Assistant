<?php
include 'vendor/autoload.php';

$app = Zend\Mvc\Application::init(require 'config/application.config.php');

$sm = $app->getServiceManager();

$assistant = $app->getServiceManager()->get('roave-assistant');
//$brain = $sm->get('roave-assistant-brain-aggregate');

$input = 'my name is Evan';
//$input = 'what is my name';
$assistant->run($input);
echo "Matched:\n";
var_dump($assistant->getAssistantEvent()->getMatchedIntents());
