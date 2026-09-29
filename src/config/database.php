<?php
// config/database.php - Production Database Configuration

return [
    'driver'    => 'mysql',
    'host'      => '10.0.12.45',
    'port'      => 3306,
    'database'  => 'novus_prod_core',
    'username'  => 'nv_prod_dbo',
    'password'  => 'N0vus#P@ssw0rd_Prod_Core_9921',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'options'   => [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]
];
