<?php

namespace DG\InstantAdminBundle;

use DG\InstantAdminBundle\Annotations\InstantAdmin;
use DG\InstantAdminBundle\Mapping\Mapping;
use DG\InstantAdminBundle\Mapping\Model\Controller;
use DG\InstantAdminBundle\Mapping\Model\Method;
use Doctrine\Common\Annotations\Reader;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class Workflow
{
    use Mapping;
    use Singleton;

    const ALLOWED_METHODS = ['index', 'new', 'show', 'edit', 'delete'];

    private $controllerReturn;

    private $annotation;
    private $methodName;
    private $entityName;
    private $entityNamespace;

    private $continue = true;

    /**
     * Workflow constructor.
     *
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function __construct(Reader $reader, string $rootPath, TagAwareCacheInterface $cache)
    {
        $this->setupControllers($reader, $rootPath, $cache);
        self::setInstance($this);
    }

    public function run(ControllerEvent $event)
    {
        preg_match('#([a-zA-Z\\\]+)::([a-zA-Z]+)$#', $event->getRequest()->get('_controller'), $matches);
        if (isset($matches[0], $matches[1], $matches[2]) && !isset($matches[3])) {
            [$requestedControllerNamespace, $requestedMethodName] = [$matches[1], $matches[2]];

            if (!array_key_exists($requestedControllerNamespace, $this->mappedControllers)) {
                return null;
            }

            /** @var Controller $mappedController */
            foreach ($this->mappedControllers as $namespace => $mappedController) {
                if ($namespace === $requestedControllerNamespace) {
                    /** @var Method $method */
                    foreach ($mappedController->getMethods() as $method) {
                        if ($method->getAdminAnnotation() &&
                        $method->getName() === $requestedMethodName &&
                        in_array($method->getName(), self::ALLOWED_METHODS)) {
                            $this->methodName = $method->getName();
                            $this->annotation = $method->getAdminAnnotation();
                        }
                    }
                }
            }

            preg_match('#([a-zA-Z]+)Controller$#', $requestedControllerNamespace, $matches);
            $this->entityName = ucfirst($matches[1]);
            $this->entityNamespace = 'App\\Entity\\'.$matches[1];
        } else {
            $this->continue = false;
        }
    }

    public function getAnnotation(): ? InstantAdmin
    {
        return $this->annotation;
    }

    public function getMethodName(): ? string
    {
        return $this->methodName;
    }

    public function getEntityName(): ? string
    {
        return $this->entityName;
    }

    public function getEntityNamespace(): ? string
    {
        return $this->entityNamespace;
    }

    /**
     * @return mixed
     */
    public function getControllerReturn()
    {
        return $this->controllerReturn;
    }

    public function setControllerReturn($controllerReturn): self
    {
        $this->controllerReturn = $controllerReturn;

        return $this;
    }

    public function isContinue(): bool
    {
        return $this->continue;
    }
}
