<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$salesman = \App\Models\User::where('role', 'sales')->first();
if (!$salesman) {
    echo "No sales user found.\n";
    exit;
}
echo "Sales user: " . $salesman->id . " - " . $salesman->name . "\n";

$sales = \App\Models\Sales::where('user_id', $salesman->id)->first();
if (!$sales) {
    echo "No sales record found for this user.\n";
    exit;
}
echo "Sales record: " . $sales->id . " - " . $sales->nama_sales . "\n";

$payrolls = \App\Models\PayrollSales::where('sales_id', $sales->id)->get();
echo "Payrolls found: " . $payrolls->count() . "\n";
foreach ($payrolls as $p) {
    echo " - Bulan: $p->bulan, Tahun: $p->tahun, Total: $p->total_gaji\n";
}
