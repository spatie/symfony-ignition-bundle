<?php

use Spatie\Ignition\Ignition;
use Spatie\SymfonyIgnitionBundle\Service\IgnitionErrorListener;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

use function Symfony\Component\DependencyInjection\Loader\Configurator\service;

return static function (ContainerConfigurator $container): void {
    $services = $container->services();

    $services
        ->set('spatie_ignition.ignition', Ignition::class)
        ->factory([Ignition::class, 'make'])
        ->call('register')
        ->private();

    $services
        ->set('spatie_ignition.error_listener', IgnitionErrorListener::class)
        ->args([
            service('spatie_ignition.ignition'),
            '%spatie_ignition.force_html_response%',
        ])
        ->tag('kernel.event_subscriber')
        ->private();
};
