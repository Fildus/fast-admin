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
        $entityNamespace = $matches[1];

        if (is_string($entityNamespace)) {
            $entityNamespace = 'App\Entity\\'.$entityNamespace;
            if (class_exists($entityNamespace)) {
                Workflow::getInstance()->setEntityNamespace($entityNamespace);

                return true;
            }
        }
        return false;
    }
}
