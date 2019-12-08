<?php

namespace DG\InstantAdminBundle\Services;

use DG\InstantAdminBundle\Workflow;
use Doctrine\Common\Persistence\ObjectManager;

class EntityNamespace
{
    private ObjectManager $manager;

    public function __construct(ObjectManager $manager)
    {
        $this->manager = $manager;
    }

    public function run()
    {
        preg_match('#([a-zA-Z]+)Controller#', Workflow::getInstance()->getControllerNamespace(), $matches);
        $entityName = $matches[1];

        if (is_string($entityName)) {
            $entityNamespace = 'App\Entity\\'.$entityName;
            if (class_exists($entityNamespace)) {
                Workflow::getInstance()->setEntityNamespace($entityNamespace);

                return true;
            }
        }
        return false;
    }
}
