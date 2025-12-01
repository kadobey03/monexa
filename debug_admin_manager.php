<?php

require_once 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Debug AdminManagerController Index Logic ===" . PHP_EOL;

$currentAdmin = App\Models\Admin::find(1);
echo "Current Admin: " . $currentAdmin->getFullName() . PHP_EOL;
echo "Is Super Admin: " . ($currentAdmin->isSuperAdmin() ? 'YES' : 'NO') . PHP_EOL;
echo PHP_EOL;

// Simulate the controller logic
$query = App\Models\Admin::with(['role', 'supervisor', 'subordinates', 'adminGroup'])
                          ->withCount(['subordinates', 'assignedUsers']);

echo "Base query created" . PHP_EOL;

// Hierarchy-based filtering
if (!$currentAdmin->isSuperAdmin()) {
    echo "Not super admin - applying filters..." . PHP_EOL;
    $manageableIds = array_merge(
        [$currentAdmin->id],
        $currentAdmin->getAllSubordinates()
    );
    echo "Manageable IDs: " . implode(', ', $manageableIds) . PHP_EOL;
    $query->whereIn('id', $manageableIds);
} else {
    echo "IS SUPER ADMIN - No filtering applied" . PHP_EOL;
}

echo PHP_EOL;
echo "Executing query..." . PHP_EOL;
$admins = $query->get();
echo "Total admins found: " . $admins->count() . PHP_EOL;

foreach($admins as $admin) {
    echo "- " . $admin->getFullName() . " (ID: " . $admin->id . ", Role: " . ($admin->role ? $admin->role->display_name : 'None') . ")" . PHP_EOL;
}

echo PHP_EOL . "=== Statistics Calculation ===" . PHP_EOL;

$stats = [
    'total_admins' => App\Models\Admin::count(),
    'active_admins' => App\Models\Admin::where('status', 'Active')->count(),
    'available_admins' => App\Models\Admin::where('is_available', true)->count(),
    'high_performers' => App\Models\Admin::where('current_performance', '>=', 80)->count(),
];

foreach($stats as $key => $value) {
    echo ucfirst(str_replace('_', ' ', $key)) . ": " . $value . PHP_EOL;
}