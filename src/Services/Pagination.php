<?php

namespace DG\InstantAdminBundle\Services;

use DG\InstantAdminBundle\Model\Pagination\Pagination as ModelPagination;
use DG\InstantAdminBundle\Repository\Repository;
use DG\InstantAdminBundle\Workflow;

class Pagination
{
    private Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function paginate()
    {
        $workflow = Workflow::getInstance();

        $itemsPerPage = 10;

        $page = $workflow->getControllerEvent()->getRequest()->get('page');
        $page = $page > 0 && $page < 1000000 && null !== $page ? $page : 1;

        [$count, $items] = $this->repository->getAllPaginate($page, $itemsPerPage);

        $pagination = new ModelPagination();
        $pagination
            ->setCurrentPageNumber($page)
            ->setItemsPerPageNumber($itemsPerPage)
            ->setItems($items)
            ->setItemsCount($count);

        return $pagination;
    }
}
