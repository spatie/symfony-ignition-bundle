<?php

namespace Spatie\SymfonyIgnitionBundle\Tests\Functional;

use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\Process\Process;

class InstallWithSymfony extends FunctionalTest
{
    /**
     * Provide Symfony versions to test
     *
     * @todo Also provide PHP versions that each Symfony version supports. Will
     *   require the test host to have Docker.
     */
    public function versionProvider()
    {
        return [
            'Symfony 5.4' => ['5.4.*'],
            'Symfony 6.0' => ['6.0.*'],
        ];
    }

    /**
     * Install a Symfony application. Verify its version with bin/console, then
     * fake a HTTP request to the front controller. Assert the response is an
     * Ignition error page thrown in a Symfony controller.
     *
     * @dataProvider versionProvider
     */
    public function testSymfonyWorks(string $symfonyRequirement): void
    {
        $this->installSymfony($symfonyRequirement);

        // Assert the expected version of Symfony was installed
        $getSymfonyVersion = new Process([
            './bin/console',
            '--version',
        ], self::APP_DIRECTORY);

        $getSymfonyVersion->run();
        $this->assertCommandIsSuccessful($getSymfonyVersion);

        $versionOutput = $getSymfonyVersion->getOutput();
        $majorDotMinorSymfonyRequirement = implode('.', explode('.', $symfonyRequirement, -1));
        $expectedOutput = sprintf('Symfony %s', $majorDotMinorSymfonyRequirement);
        $this->assertStringContainsString($expectedOutput, $versionOutput);

        // Make a request that will result in an exception. Assert it looks like an Ignition page.
        $httpRequest = $this->runSymfonyHttpRequest();
        $this->assertCommandIsSuccessful($httpRequest, failOnErrorOutput: false);
        $html = $httpRequest->getOutput();

        $crawler = new Crawler($html);
        $title = $crawler->filterXPath('//head/title')->text();

        // Symfony adds this to the page title. Ignition does not.
        $this->assertStringNotContainsString('(500 Internal Server Error)', $title);

        // Assert the expected exception message is in the title
        $expectedTitle = sprintf('Test Exception: Symfony %s', $majorDotMinorSymfonyRequirement);
        $this->assertStringContainsString($expectedTitle, $title);
    }
}
