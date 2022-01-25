<?php

namespace Spatie\SymfonyIgnitionBundle\Service;

use ob_start, ob_get_contents, ob_end_clean;
use Spatie\Ignition\Ignition;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class IgnitionErrorListener implements EventSubscriberInterface
{
    public function __construct(
        private Ignition $ignition,
    ) {}

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

        // Get the output from Ignition
        ob_start();
        $this->ignition->handleException($error);
        $output = ob_get_contents();
        ob_end_clean();

        // Return Ignition's output as a Symfony response
        $response = new Response($output);
        $event->setResponse($response);
    }
}
