<?php
namespace Roave\Assistant;

class Intent implements IntentInterface
{
    protected $name;

    protected $expressions = [];

    protected $isFinal = false;

    public function __construct($name = null)
    {
        if ($name) {
            $this->setName($name);
        }
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function isFinal()
    {
        return $this->isFinal;
    }

    public function setFinal($final)
    {
        $this->isFinal = $final;
    }

    public function addExpressions(array $expressions)
    {
        $this->expressions = array_merge($this->expressions, $expressions);
    }

    public function match($string)
    {
        foreach ($this->expressions as $expression) {
            if (preg_match("/{$expression}/i", $string, $matches)) {
                return true;
            }
        }

        return false;
    }
}
