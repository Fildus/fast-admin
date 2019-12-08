<?php

namespace DG\InstantAdminBundle\EventSubscriber;

use DG\InstantAdminBundle\Services\AdminAnnotation;
use DG\InstantAdminBundle\Services\AdminControllers;
use DG\InstantAdminBundle\Services\ControllerNamespace;
use DG\InstantAdminBundle\Services\EntityNamespace;
use DG\InstantAdminBundle\Services\MethodName;
use DG\InstantAdminBundle\Workflow;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ControllerSubscriber implements EventSubscriberInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @throws \Psr\Cache\InvalidArgumentException
     */
    public function onKernelControllerEvent(ControllerEvent $event)
    {
        if ($event->isMasterRequest()) {
            Workflow::setInstance()->setControllerEvent($event);

            if ($this->container->get(AdminControllers::class)->run() &&
                $this->container->get(ControllerNamespace::class)->run() &&
                $this->container->get(MethodName::class)->run() &&
                $this->container->get(AdminAnnotation::class)->run() &&
                $this->container->get(EntityNamespace::class)->run()
            ) {
                $controller = $this->container->get(Workflow::getInstance()->getControllerNamespace());
                $method = Workflow::getInstance()->getMethodName();

                $controllerReturn = $controller->$method();
                Workflow::getInstance()->setControllerReturn($controllerReturn);

                $controller = $this->container->get('instant_admin_bundle.instant_admin_controller');
                $event->setController(fn () => $controller->$method());
            }
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelControllerEvent',
        ];
    }
}
