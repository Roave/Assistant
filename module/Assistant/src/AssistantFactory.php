<?php
namespace Roave\Assistant;

class AssistantFactory
{
    public function __invoke($serviceLocator)
    {
        return new Assistant();
    }
}
