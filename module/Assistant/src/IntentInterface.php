<?php
namespace Roave\Assistant;

interface IntentInterface
{
    public function getName();
    public function setName($name);
    public function isFinal();
    public function setFinal($final);
    public function match($string);
}
