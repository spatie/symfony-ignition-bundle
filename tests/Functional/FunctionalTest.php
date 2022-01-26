<?php

declare(strict_types=1);

namespace Spatie\SymfonyIgnitionBundle\Tests\Functional;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Process\Process;

abstract class FunctionalTest extends TestCase
{
    // This is where the test Symfony application will be created
    protected const APP_DIRECTORY = __DIR__ . '/App';
    // These are the initial assets to use when creating a new Symfony application
    protected const APP_TEMPLATE = __DIR__ . '/AppTemplate';

    abstract public function testSymfonyworks(string $symfonyVersion): void;

    protected function installSymfony(string $symfonyRequirement = '6.0.*'): void
    {
        // Create a fresh directory for the Symfony app using the template
        $filesystem = new Filesystem();
        $filesystem->remove(self::APP_DIRECTORY);
        $filesystem->mirror(self::APP_TEMPLATE, self::APP_DIRECTORY);

        // Install packages
        $composerInstall = new Process(
            [
                'composer',
                'install',
                '--no-interaction',
                '--prefer-dist',
                '--optimize-autoloader',
            ],
            self::APP_DIRECTORY,
            ['SYMFONY_REQUIRE' => $symfonyRequirement]
        );

        $composerInstall->mustRun();
    }

    public function runSymfonyHttpRequest(): Process
    {
        $httpCall = new Process(
            [
                'php',
                'public/index.php',
            ],
            self::APP_DIRECTORY
        );

        $httpCall->run();

        return $httpCall;
    }

    protected function assertCommandIsSuccessful(Process $command, bool $failOnErrorOutput = true): void
    {
        $message = $command->getOutput() . PHP_EOL . $command->getErrorOutput();
        $this->assertTrue($command->isSuccessful(), $message);

        if ($failOnErrorOutput) {
            $this->assertStringNotContainsStringIgnoringCase('Warning', $message, $message);
            $this->assertStringNotContainsStringIgnoringCase('Error', $message, $message);
        }
    }
}
