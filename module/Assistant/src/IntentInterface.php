<?php
namespace Roave\Assistant;

interface IntentInterface
{
    public function getName();
    public function setName($name);
    public function matches($string);

    public function addExpressions(array $expressions);
    public function attach(Assistant $assistant);
}
