<?php

namespace Spatie\SymfonyIgnitionBundle\Service;

use Spatie\Ignition\Ignition;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class IgnitionErrorListener implements EventSubscriberInterface
{
    private $ignition;

    public function __construct(Ignition $ignition)
    {
        $this->ignition = $ignition;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['onKernelException', -127], // The default error listener is -128
            ],
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        $error = $event->getThrowable();

        /**
         * @todo Capture ignition HTML response and return that as a Symfony
         * response, instead of using Ignition's rendering. This will be needed
         * for the Symfony debug toolbar to show up, and for other exception
         * listeners to be called.
         *
         * $response = new \Symfony\Component\HttpFoundation\Response($ignitionOutput);
         * $event->setResponse($response);
         */
        $this->ignition->handleException($error);
        exit(1);
    }
}
