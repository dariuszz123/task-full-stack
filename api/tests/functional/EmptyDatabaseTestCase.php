<?php


namespace App\Tests\functional;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Input\StringInput;

abstract class EmptyDatabaseTestCase extends WebTestCase
{
    protected static $application;

    public static function setUpBeforeClass()
    {
        self::runCommand('doctrine:schema:drop --force');
        self::runCommand('doctrine:schema:update --force');
    }

    protected static function getApplication(): Application
    {
        if (null === self::$application) {
            $client = static::createClient();

            self::$application = new Application($client->getKernel());
            self::$application->setAutoExit(false);
            self::$application->setCatchExceptions(false);
        }

        return self::$application;
    }

    protected static function runCommand($command) :int
    {
        $command = sprintf('%s --no-interaction', $command);

        $input = new StringInput($command);
        $input->setInteractive(false);

        return self::getApplication()->run($input);
    }
}