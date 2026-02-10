<?php
/**
 * Cache Clear & Setup Script for cPanel Deployment
 * Access via: https://shareij.org/clear-cache.php
 * DELETE THIS FILE after use for security!
 */

// Simple security - only allow with correct token
$token = $_GET['token'] ?? '';
if ($token !== 'shareij2026setup') {
    http_response_code(403);
    echo "Access denied. Use ?token=shareij2026setup";
    exit;
}

echo "<pre style='font-family:monospace; background:#1a1a2e; color:#0f0; padding:20px;'>";
echo "=== SHARE IJ - Cache Clear & Setup ===\n\n";

// Find artisan
$basePath = dirname(__DIR__);
$artisan = $basePath . '/artisan';

if (!file_exists($artisan)) {
    // Try one level up (if public_html is the public folder)
    $basePath = dirname($basePath);
    $artisan = $basePath . '/artisan';
}

if (!file_exists($artisan)) {
    echo "ERROR: Could not find artisan file.\n";
    echo "Checked: " . dirname(__DIR__) . "/artisan\n";
    echo "Checked: " . $basePath . "/artisan\n";
    echo "</pre>";
    exit;
}

echo "Found artisan at: $artisan\n";
echo "Base path: $basePath\n\n";

// Commands to run
$commands = [
    'config:clear' => 'Clearing config cache',
    'route:clear' => 'Clearing route cache',
    'cache:clear' => 'Clearing application cache',
    'view:clear' => 'Clearing compiled views',
];

foreach ($commands as $cmd => $label) {
    echo "[$label] php artisan $cmd\n";
    $output = [];
    $code = 0;
    exec("cd " . escapeshellarg($basePath) . " && php artisan $cmd 2>&1", $output, $code);
    echo "  → " . implode("\n  → ", $output) . "\n";
    echo "  Exit code: $code\n\n";
}

// Composer dump-autoload
echo "[Regenerating autoload] composer dump-autoload\n";
$output = [];
$code = 0;
exec("cd " . escapeshellarg($basePath) . " && composer dump-autoload 2>&1", $output, $code);
echo "  → " . implode("\n  → ", $output) . "\n";
echo "  Exit code: $code\n\n";

// Check if tables exist
echo "=== Database Check ===\n";
try {
    require $basePath . '/vendor/autoload.php';
    $app = require_once $basePath . '/bootstrap/app.php';
    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();

    $tables = ['pages', 'menus', 'settings', 'users'];
    foreach ($tables as $table) {
        $exists = \Illuminate\Support\Facades\Schema::hasTable($table);
        echo "  Table '$table': " . ($exists ? "✓ EXISTS" : "✗ MISSING") . "\n";
    }

    if (!\Illuminate\Support\Facades\Schema::hasTable('pages') || !\Illuminate\Support\Facades\Schema::hasTable('menus')) {
        echo "\n⚠ Missing tables! Run the SQL from database/production_sql.sql in phpMyAdmin.\n";
    }
} catch (Exception $e) {
    echo "  Could not check DB: " . $e->getMessage() . "\n";
}

echo "\n=== Done! ===\n";
echo "⚠ DELETE this file (clear-cache.php) after use for security!\n";
echo "</pre>";
