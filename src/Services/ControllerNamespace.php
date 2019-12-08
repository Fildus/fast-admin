<?php

namespace DG\InstantAdminBundle\Services;

use DG\InstantAdminBundle\Workflow;

class ControllerNamespace
{
    public function run(): bool
    {
        if (is_array($array = Workflow::getInstance()->getControllerEvent()->getController())) {
            Workflow::getInstance()->setControllerNamespace(get_class($array[0]));
            return true;
        }

        Workflow::getInstance()->setControllerNamespace(null);
        return false;
    }
}
