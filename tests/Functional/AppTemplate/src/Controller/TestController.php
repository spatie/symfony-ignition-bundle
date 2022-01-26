<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class TestController extends AbstractController
{
    public function index(): Response
    {
        $symfonyVersion = \Symfony\Component\HttpKernel\Kernel::VERSION;
        $phpVersion = PHP_VERSION;

        throw new \Exception(sprintf('Test Exception: Symfony %s PHP %s', $symfonyVersion, $phpVersion));

        return new Response('We should never see this');
    }
}
