<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

$tables = DB::select('SHOW TABLES');
$tableNames = [];
foreach($tables as $table) {
    $tableNames[] = array_values((array) $table)[0];
}

$keep = [
    'kategori_barangs',
    'users',
    'suppliers',
    'buyers',
    'kecamatans',
    
    // System tables
    'migrations',
    'password_reset_tokens',
    'failed_jobs',
    'job_batches',
    'jobs',
    'cache',
    'cache_locks',
    'sessions',
    'personal_access_tokens',
    'roles',
    'permissions',
    'model_has_permissions',
    'model_has_roles',
    'role_has_permissions'
];

$toDelete = array_diff($tableNames, $keep);

DB::statement('SET FOREIGN_KEY_CHECKS=0;');
foreach($toDelete as $table) {
    echo "Truncating $table\n";
    DB::table($table)->truncate();
}
DB::statement('SET FOREIGN_KEY_CHECKS=1;');

echo "Done!\n";
