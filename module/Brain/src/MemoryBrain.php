<?php
namespace Roave\Assistant\Brain;

class MemoryBrain implements BrainInterface
{
    protected $data = [];

    public function __construct($data = null)
    {
        if ($data) {
            $this->data = $data;
        }
    }

    public function store($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function fetch($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }
}
