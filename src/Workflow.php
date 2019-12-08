<?php

namespace DG\InstantAdminBundle;

use DG\InstantAdminBundle\Annotations\InstantAdmin;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class Workflow
{
    private static ?Workflow $instance = null;
    private ControllerEvent $controllerEvent;
    private ?array $mappedControllers;
    private ?string $controllerNamespace;
    private ?string $methodName;
    private ?InstantAdmin $instantAdminAnnotation;
    private ?string $entityNamespace;
    private ?array $controllerReturn;

    public static function setInstance()
    {
        self::$instance = new Workflow();

        return self::$instance;
    }

    public static function getInstance(): Workflow
    {
        if (!self::$instance) {
            self::$instance = new Workflow();
        }

        return self::$instance;
    }

    public function setControllerEvent(ControllerEvent $controllerEvent): self
    {
        $this->controllerEvent = $controllerEvent;

        return $this;
    }

    public function getControllerEvent(): ?ControllerEvent
    {
        return $this->controllerEvent;
    }

    public function getMappedControllers(): ?array
    {
        return $this->mappedControllers;
    }

    public function setMappedControllers(array $mappedControllers): self
    {
        $this->mappedControllers = $mappedControllers;

        return $this;
    }

    public function getControllerNamespace(): ?string
    {
        return $this->controllerNamespace;
    }

    public function setControllerNamespace(?string $controllerNamespace): self
    {
        $this->controllerNamespace = $controllerNamespace;

        return $this;
    }

    public function getMethodName(): ?string
    {
        return $this->methodName;
    }

    public function setMethodName(?string $methodName): self
    {
        $this->methodName = $methodName;

        return $this;
    }

    public function setInstantAdminAnnotation(?InstantAdmin $instantAdminAnnotation): self
    {
        $this->instantAdminAnnotation = $instantAdminAnnotation;

        return $this;
    }

    public function getEntityNamespace(): ?string
    {
        return $this->entityNamespace;
    }

    public function setEntityNamespace(?string $entityNamespace): self
    {
        $this->entityNamespace = $entityNamespace;

        return $this;
    }

    public function getControllerReturn(): ?array
    {
        return $this->controllerReturn;
    }

    public function setControllerReturn($controllerReturn): self
    {
        $this->controllerReturn = is_array($controllerReturn) && null !== $this->controllerNamespace ?
            $controllerReturn :
            [$controllerReturn];

        return $this;
    }
}
