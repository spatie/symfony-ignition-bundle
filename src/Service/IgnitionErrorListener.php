<?php

namespace Spatie\SymfonyIgnitionBundle\Service;

use function ob_get_clean;
use function ob_start;

use Spatie\Ignition\Ignition;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class IgnitionErrorListener implements EventSubscriberInterface
{
    public function __construct(
        private Ignition $ignition,
        private bool $forceHtmlResponse = true,
    ) {
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
        // If the request expects a non-HTML mime type and
        // force_html_response == false, fall through to Symfony's error handling.
        if (! $this->forceHtmlResponse) {
            $preferredFormat = $event->getRequest()->getPreferredFormat('html');
            if ($preferredFormat !== 'html') {
                return;
            }
        }

        $error = $event->getThrowable();

        // Get the output from Ignition
        ob_start();
        $this->ignition->handleException($error);
        $output = ob_get_clean();

        // Return Ignition's output as a Symfony response
        $response = new Response($output);
        $event->setResponse($response);
    }
}
