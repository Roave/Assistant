<?php
namespace Roave\Assistant;

class AssistantFactory
{
    public function __invoke($serviceManager)
    {
        return new Assistant();
    }
}
