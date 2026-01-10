<?php

require_once 'vendor/autoload.php';

use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Doctrine\UuidType;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Symfony\Component\Cache\Adapter\ArrayAdapter;

// Load environment variables
$envFile = __DIR__ . '/prat.env';
if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $_ENV[$key] = $value;
        }
    }
}

// Database configuration
$dbParams = [
    'driver'   => $_ENV['DB_DRIVER'] ?? 'pdo_pgsql',
    'host'     => $_ENV['DB_HOST'] ?? 'praticien.db',
    'port'     => $_ENV['DB_PORT'] ?? 5432,
    'dbname'   => $_ENV['DB_NAME'] ?? $_ENV['POSTGRES_DB'] ?? 'prati',
    'user'     => $_ENV['DB_USER'] ?? $_ENV['POSTGRES_USER'] ?? 'prati',
    'password' => $_ENV['DB_PASSWORD'] ?? $_ENV['POSTGRES_PASSWORD'] ?? '',
    'charset'  => 'utf8',
];

if (!Type::hasType('uuid')) {
    Type::addType('uuid', UuidType::class);
}

$config = ORMSetup::createAttributeMetadataConfiguration(
    paths: [__DIR__ . '/src/Entity'],
    isDevMode: true,
    cache: new ArrayAdapter(),
);

$connection = DriverManager::getConnection($dbParams, $config);

// Ensure the platform knows about the types
$platform = $connection->getDatabasePlatform();
$platform->registerDoctrineTypeMapping('uuid', 'uuid');
// bit(1) in Postgres wire protocol is often returned as a string or binary, not a simple 0/1 integer
$platform->registerDoctrineTypeMapping('bit', 'string');

$entityManager = new EntityManager($connection, $config);

return $entityManager;
