<?php
namespace Roave\Assistant;

use Zend\ServiceManager\AbstractPluginManager;

class PluginManager extends AbstractPluginManager
{
    public function validatePlugin($plugin)
    {
        return true;
    }
}
