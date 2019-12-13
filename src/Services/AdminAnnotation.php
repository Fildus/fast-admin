<?php

namespace DG\InstantAdminBundle\Services;

use DG\InstantAdminBundle\Mapping\Model\Controller;
use DG\InstantAdminBundle\Mapping\Model\Method;
use DG\InstantAdminBundle\Workflow;

class AdminAnnotation
{
    public function run(): bool
    {
        if (key_exists(Workflow::getInstance()->getControllerNamespace(), Workflow::getInstance()->getMappedControllers())) {
            /** @var Controller $modelController */
            $modelController = Workflow::getInstance()->getMappedControllers()[Workflow::getInstance()->getControllerNamespace()];

            /** @var Method $modelMethod */
            $modelMethod = $modelController->getMethods()[Workflow::getInstance()->getMethodName()];

            $modelMethod->getAdminAnnotation();

            if (Workflow::getInstance()) {
                Workflow::getInstance()->setInstantAdminAnnotation($modelMethod->getAdminAnnotation());

                return true;
            }
        }
        Workflow::getInstance()->setInstantAdminAnnotation(null);

        return false;
    }
}
