<?php

declare(strict_types=1);

namespace Spatie\SymfonyIgnitionBundle\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Spatie\Ignition\Ignition;
use Spatie\SymfonyIgnitionBundle\Service\IgnitionErrorListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

class IgnitionErrorListenerTest extends TestCase
{
    public function testSubscribedEventPriority(): void
    {
        $events = IgnitionErrorListener::getSubscribedEvents();

        $this->assertArrayHasKey(KernelEvents::EXCEPTION, $events);
        $this->assertSame(-127, $events[KernelEvents::EXCEPTION][0][1]);
    }

    public function testForceHtmlResponseTrueRendersIgnitionForJsonAccept(): void
    {
        $ignition = $this->createMock(Ignition::class);
        $ignition->expects($this->once())->method('handleException');

        $listener = new IgnitionErrorListener($ignition, true);

        $request = new Request();
        $request->headers->set('Accept', 'application/json');

        $event = $this->createExceptionEvent($request);
        $listener->onKernelException($event);

        $this->assertNotNull($event->getResponse());
    }

    public function testForceHtmlResponseFalseBypassesIgnitionForJsonAccept(): void
    {
        $ignition = $this->createMock(Ignition::class);
        $ignition->expects($this->never())->method('handleException');

        $listener = new IgnitionErrorListener($ignition, false);

        $request = new Request();
        $request->headers->set('Accept', 'application/json');

        $event = $this->createExceptionEvent($request);
        $listener->onKernelException($event);

        $this->assertNull($event->getResponse());
    }

    public function testForceHtmlResponseFalseBypassesIgnitionForRouteFormatJson(): void
    {
        $ignition = $this->createMock(Ignition::class);
        $ignition->expects($this->never())->method('handleException');

        $listener = new IgnitionErrorListener($ignition, false);

        $request = new Request();
        $request->setRequestFormat('json');

        $event = $this->createExceptionEvent($request);
        $listener->onKernelException($event);

        $this->assertNull($event->getResponse());
    }

    public function testForceHtmlResponseFalseRendersIgnitionForHtmlAccept(): void
    {
        $ignition = $this->createMock(Ignition::class);
        $ignition->expects($this->once())->method('handleException');

        $listener = new IgnitionErrorListener($ignition, false);

        $request = new Request();
        $request->headers->set('Accept', 'text/html');

        $event = $this->createExceptionEvent($request);
        $listener->onKernelException($event);

        $this->assertNotNull($event->getResponse());
    }

    public function testForceHtmlResponseFalseRendersIgnitionForWildcardAccept(): void
    {
        $ignition = $this->createMock(Ignition::class);
        $ignition->expects($this->once())->method('handleException');

        $listener = new IgnitionErrorListener($ignition, false);

        $request = new Request();
        $request->headers->set('Accept', '*/*');

        $event = $this->createExceptionEvent($request);
        $listener->onKernelException($event);

        $this->assertNotNull($event->getResponse());
    }

    public function testForceHtmlResponseFalseRendersIgnitionForNoAcceptHeader(): void
    {
        $ignition = $this->createMock(Ignition::class);
        $ignition->expects($this->once())->method('handleException');

        $listener = new IgnitionErrorListener($ignition, false);

        $request = new Request();

        $event = $this->createExceptionEvent($request);
        $listener->onKernelException($event);

        $this->assertNotNull($event->getResponse());
    }

    public function testForceHtmlResponseFalseBypassesIgnitionForXmlAccept(): void
    {
        $ignition = $this->createMock(Ignition::class);
        $ignition->expects($this->never())->method('handleException');

        $listener = new IgnitionErrorListener($ignition, false);

        $request = new Request();
        $request->headers->set('Accept', 'application/xml');

        $event = $this->createExceptionEvent($request);
        $listener->onKernelException($event);

        $this->assertNull($event->getResponse());
    }

    private function createExceptionEvent(Request $request): ExceptionEvent
    {
        $kernel = $this->createMock(HttpKernelInterface::class);

        return new ExceptionEvent(
            $kernel,
            $request,
            HttpKernelInterface::MAIN_REQUEST,
            new \RuntimeException('Test exception')
        );
    }
}
