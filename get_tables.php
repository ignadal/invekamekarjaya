<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;

$tables = Schema::getTables();
$tableNames = array_map(function($table) {
    return $table['name'];
}, $tables);

echo json_encode($tableNames);
