<?php

namespace DG\InstantAdminBundle\Controller;

use DG\InstantAdminBundle\Functions\EntityFunctions;
use DG\InstantAdminBundle\Repository\Repository;
use DG\InstantAdminBundle\Workflow;
use Doctrine\Common\Annotations\AnnotationException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class InstantAdminController extends AbstractController
{
    /**
     * @var Repository
     */
    private $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Response
     *
     * @throws AnnotationException
     * @throws \ReflectionException
     */
    public function index()
    {
        /** @var Workflow $workflow */
        $workflow = Workflow::getInstance();

        return $this->render('@DGInstantAdmin/index.html.twig', [
            'entities' => $this->repository->findAll(),
            'entityName' => $workflow->getEntityName(),
            'methodName' => $workflow->getMethodName(),
            'annotation' => $workflow->getAnnotation(),
            'entityProperties' => EntityFunctions::getEntityProperties($workflow->getEntityNamespace()),
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
