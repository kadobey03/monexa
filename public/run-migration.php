<?php
require_once '../vendor/autoload.php';

$app = require_once '../bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "<h2>🚀 Running Migration</h2>";

try {
    // Check current table structure
    $exists = \Illuminate\Support\Facades\Schema::hasTable('user_plans');
    
    if ($exists) {
        echo "✅ user_plans table exists<br><br>";
        
        // Check if active column already exists
        if (\Illuminate\Support\Facades\Schema::hasColumn('user_plans', 'active')) {
            echo "✅ 'active' column already exists<br>";
        } else {
            echo "➕ Adding 'active' column...<br>";
            \Illuminate\Support\Facades\Schema::table('user_plans', function ($table) {
                $table->string('active')->default('yes')->after('amount');
            });
            echo "✅ 'active' column added<br>";
        }
        
        // Check if assets column already exists
        if (\Illuminate\Support\Facades\Schema::hasColumn('user_plans', 'assets')) {
            echo "✅ 'assets' column already exists<br>";
        } else {
            echo "➕ Adding 'assets' column...<br>";
            \Illuminate\Support\Facades\Schema::table('user_plans', function ($table) {
                $table->string('assets')->nullable()->after('active');
            });
            echo "✅ 'assets' column added<br>";
        }
        
        // Check if leverage column already exists
        if (\Illuminate\Support\Facades\Schema::hasColumn('user_plans', 'leverage')) {
            echo "✅ 'leverage' column already exists<br>";
        } else {
            echo "➕ Adding 'leverage' column...<br>";
            \Illuminate\Support\Facades\Schema::table('user_plans', function ($table) {
                $table->string('leverage')->nullable()->after('assets');
            });
            echo "✅ 'leverage' column added<br>";
        }
        
        echo "<br><h3>📋 Final table structure:</h3>";
        $columns = \Illuminate\Support\Facades\DB::select("DESCRIBE user_plans");
        foreach ($columns as $column) {
            $nullable = $column->Null === 'YES' ? 'NULL' : 'NOT NULL';
            $default = $column->Default !== null ? "DEFAULT: {$column->Default}" : 'NO DEFAULT';
            echo "- {$column->Field} ({$column->Type}) {$nullable} {$default}<br>";
        }
        
        echo "<br><strong style='color: green; font-size: 18px;'>🎯 MIGRATION COMPLETED SUCCESSFULLY!</strong><br>";
        
    } else {
        echo "❌ user_plans table does not exist!<br>";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
    echo "📋 Error details: " . $e->getFile() . " line " . $e->getLine() . "<br>";
}
?>