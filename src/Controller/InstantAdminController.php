<?php

namespace DG\InstantAdminBundle\Controller;

use DG\InstantAdminBundle\Repository\Repository;
use DG\InstantAdminBundle\Workflow;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class InstantAdminController extends AbstractController
{
    use EntityMetadata;

    private Repository $repository;
    private EntityManager $entityManager;

    public function __construct(Repository $repository, EntityManager $entityManager)
    {
        $this->repository = $repository;
        $this->entityManager = $entityManager;
    }

    public function index()
    {
        return $this->render('@DGInstantAdmin/index.html.twig', [
            'entities' => $this->repository->findAll(),
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
