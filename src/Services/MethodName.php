<?php

namespace DG\InstantAdminBundle\Services;

use DG\InstantAdminBundle\Methods;
use DG\InstantAdminBundle\Workflow;

class MethodName
{
    public function run(): bool
    {
        if (is_array($array = Workflow::getInstance()->getControllerEvent()->getController())) {
            $method = $array[1];
            if (in_array($method, Methods::ALLOWED_METHODS)) {
                Workflow::getInstance()->setMethodName($method);
                return true;
            }
        }

        Workflow::getInstance()->setMethodName(null);
        return false;
    }
}
