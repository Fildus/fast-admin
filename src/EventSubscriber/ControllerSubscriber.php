<?php

namespace DG\InstantAdminBundle\EventSubscriber;

use DG\InstantAdminBundle\Workflow;
use Psr\Container\ContainerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class ControllerSubscriber implements EventSubscriberInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function onKernelControllerEvent(ControllerEvent $event)
    {
        $this->container->get('DG\InstantAdminBundle\Workflow')->run($event);

        /** @var Workflow $workflow */
        $workflow = Workflow::getInstance();

        if ($workflow->getAnnotation()) {
            $workflow->setControllerReturn(
                call_user_func([
                    get_class($event->getController()[0]),
                    $event->getController()[1],
                ]));

            return $event->setController([
                $this->container->get('DG\InstantAdminBundle\Controller\InstantAdminController'),
                $workflow->getMethodName(),
            ]);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelControllerEvent',
        ];
    }
}
