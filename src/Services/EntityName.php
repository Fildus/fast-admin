<?php

namespace DG\InstantAdminBundle\Services;

use DG\InstantAdminBundle\Workflow;
use Doctrine\Common\Persistence\ObjectManager;

class EntityName
{
    private ObjectManager $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function run()
    {
        preg_match('#([a-zA-Z]+)Controller#', Workflow::getInstance()->getControllerNamespace(), $matches);
        $entityName = strtolower($matches[1]);
        if (is_string($entityName)) {
            Workflow::getInstance()->setEntityName($entityName);

            return true;
        }
        Workflow::getInstance()->setEntityName(null);

        return false;
    }
}
