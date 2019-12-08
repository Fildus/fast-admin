<?php

namespace DG\InstantAdminBundle\Controller;

use App\Entity\Project;
use DG\InstantAdminBundle\Workflow;
use Doctrine\ORM\EntityManager;

trait EntityMetadata
{
    public function getEntityMetadata(): array
    {
        /** @var EntityManager $em */
        $em = $this->entityManager;

        $entityMetadata = $em->getClassMetadata(Workflow::getInstance()->getEntityNamespace());

        $fields = (array) $entityMetadata->fieldMappings;
        $associationMappings = (array) $entityMetadata->getAssociationMappings();

        return array_merge($fields, $associationMappings);
    }
}
