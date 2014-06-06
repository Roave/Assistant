<?php
namespace Roave\Assistant\Brain;

interface BrainInterface
{
    public function store($key, $value);
    public function fetch($key);
}
