<?php

declare(strict_types=1);

use App\Application\Settings\Settings;
use App\Application\Settings\SettingsInterface;
use DI\ContainerBuilder;
use Monolog\Logger;

return function (ContainerBuilder $containerBuilder) {

    // Global Settings Object
    $containerBuilder->addDefinitions([
        SettingsInterface::class => function () {
            return new Settings([
                'displayErrorDetails' => true, // Should be set to false in production
                'logError'            => false,
                'logErrorDetails'     => false,
                'logger' => [
                    'name' => 'slim-app',
                    'path' => isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log',
                    'level' => Logger::DEBUG,
                ],
                //'db' => [
                //    'driver' => 'mysql',
                //    'host' => 'localhost',
                //    'username' => 'root',
                //    'database' => 'ap2_pi2',
                //    'password' => '1234',
                //    'charset' => 'utf8mb4',
                //    'collation' => 'utf8mb4_unicode_ci',
                //    'flags' => [
                //        // Turn off persistent connections
                //        PDO::ATTR_PERSISTENT => false,
                //        // Enable exceptions
                //        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                //        // Emulate prepared statements
                //        PDO::ATTR_EMULATE_PREPARES => true,
                //        // Set default fetch mode to array
                //        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                //    ],
                //],
                'db' => [
                    'driver' => 'mysql',
                    'host' => 'localhost',
                    'username' => 'root',
                    'database' => 'GP2324',
                    'password' => '1234',
                    'charset' => 'utf8mb4',
                    'collation' => 'utf8mb4_unicode_ci',
                    'flags' => [
                        // Turn off persistent connections
                        PDO::ATTR_PERSISTENT => false,
                        // Enable exceptions
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        // Emulate prepared statements
                        PDO::ATTR_EMULATE_PREPARES => true,
                        // Set default fetch mode to array
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ],
                ],
            ]);
        }
    ]);
};
