<?php

namespace DG\InstantAdminBundle\Controller;

use DG\InstantAdminBundle\Repository\Repository;
use DG\InstantAdminBundle\Services\Pagination;
use DG\InstantAdminBundle\Workflow;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class InstantAdminController extends AbstractController
{
    use EntityMetadata;

    private Repository $repository;
    private EntityManager $entityManager;
    private Paginator $paginator;

    public function __construct(Repository $repository, EntityManager $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function index()
    {
        dump($this->container->get(Pagination::class)->paginate());
        return $this->render('@DGInstantAdmin/index.html.twig', [
            'pagination' => $this->container->get(Pagination::class)->paginate(),
            'workflow' => Workflow::getInstance(),
            'entityMetadata' => $this->getEntityMetadata(),
        ]);
    }

    public function new()
    {
        return new Response('<html><body>new</body></html>');
    }

    public function show()
    {
        return new Response('<html><body>show</body></html>');
    }

    public function edit()
    {
        return new Response('<html><body>edit</body></html>');
    }

    public function delete()
    {
        return new Response('<html><body>delete</body></html>');
    }
}
