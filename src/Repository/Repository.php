<?php

namespace DG\InstantAdminBundle\Repository;

use DG\InstantAdminBundle\Workflow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @method find($id, $lockMode = null, $lockVersion = null)
 * @method findOneBy(array $criteria, array $orderBy = null)
 * @method findAll()
 * @method findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workflow::getInstance()->getEntityNamespace());
    }

    public function getFindAllQuery()
    {
        $sortDirection = Workflow::getInstance()->getControllerEvent()->getRequest()->get('sortDirection');
        $sortField = Workflow::getInstance()->getControllerEvent()->getRequest()->get('sortField');

        $qb = $this->createQueryBuilder('e');

        if ($sortDirection && $sortField) {
            $qb->orderBy('e.'.$sortField, $sortDirection);
        }

        return $qb->getQuery();
    }

    public function getAllPaginate(int $page = 1, int $itemsPerPage = 10)
    {
        $sortDirection = Workflow::getInstance()->getControllerEvent()->getRequest()->get('sortDirection');
        $sortField = Workflow::getInstance()->getControllerEvent()->getRequest()->get('sortField');

        $qb = $this->createQueryBuilder('e');

        if ($sortDirection && $sortField) {
            $qb->orderBy('e.'.$sortField, $sortDirection);
        } else {
            $qb->orderBy('e.id', 'ASC');
        }

        $firstResult = function () use ($page, $itemsPerPage) {
            if (1 === $page) {
                return 0;
            }

            return ($page - 1) * $itemsPerPage;
        };

        $qb
            ->select('e')
            ->setFirstResult($firstResult())
            ->setMaxResults($itemsPerPage);

        $pagination = new Paginator($qb);

        $count = count($pagination);

        $results = $qb->getQuery()->getResult();

        return [$count, $results];
    }
}
