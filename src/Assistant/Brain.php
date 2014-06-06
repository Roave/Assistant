<?php
namespace Assistant;

interface Brain
{
    public function remember($brainID, $key, $value);
}
