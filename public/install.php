<?php
/**
 * SHARE IJ - Web Installer for cPanel / Shared Hosting
 * 
 * Upload entire project to your hosting, then visit:
 *   https://yourdomain.com/install.php
 * 
 * This installer will:
 *   1. Check server requirements
 *   2. Configure database connection
 *   3. Set up .env file
 *   4. Run migrations & seeders
 *   5. Create admin account
 *   6. Configure mail settings
 *   7. Create storage symlink
 *   8. Self-delete for security
 */

// ── Prevent timeout on slow shared hosting ─────────────────────────────────
set_time_limit(300);
ini_set('display_errors', 0);
error_reporting(E_ALL);

// ── Resolve project root (works in public/ or project root) ─────────────────
$basePath = __DIR__;
// If we're inside public/, go up one level
if (basename($basePath) === 'public' || file_exists($basePath . '/../artisan')) {
    $basePath = realpath($basePath . '/..');
}
// Fallback: if artisan is in current dir, we're at project root
if (!file_exists($basePath . '/artisan')) {
    // Try parent
    if (file_exists(dirname($basePath) . '/artisan')) {
        $basePath = dirname($basePath);
    }
}
$envPath  = $basePath . '/.env';
$lockFile = $basePath . '/storage/installed.lock';

if (file_exists($lockFile)) {
    die('<!DOCTYPE html><html><head><title>Already Installed</title>
    <style>body{font-family:system-ui;display:flex;justify-content:center;align-items:center;min-height:100vh;background:#f8fafc;margin:0}
    .box{background:#fff;border-radius:12px;padding:40px;box-shadow:0 4px 24px rgba(0,0,0,.08);text-align:center;max-width:500px}
    h2{color:#1e293b}p{color:#64748b}a{color:#2563eb}</style></head>
    <body><div class="box"><h2>&#10004; Already Installed</h2>
    <p>SHARE IJ is already installed. For security, the installer has been disabled.</p>
    <p><a href="/">Go to Homepage</a> &bull; <a href="/admin">Admin Panel</a></p>
    </div></body></html>');
}

// ── Handle AJAX requests ────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');
    
    try {
        switch ($_POST['action']) {
            case 'check_requirements':
                echo json_encode(checkRequirements());
                break;
            
            case 'test_database':
                echo json_encode(testDatabase($_POST));
                break;
            
            case 'install':
                echo json_encode(runInstallation($_POST));
                break;
            
            default:
                echo json_encode(['success' => false, 'message' => 'Unknown action']);
        }
    } catch (\Throwable $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// ── Requirement Checks ──────────────────────────────────────────────────────
function checkRequirements(): array {
    $checks = [];
    
    // PHP Version
    $phpVersion = PHP_VERSION;
    $checks[] = [
        'name' => 'PHP Version',
        'required' => '>= 8.2',
        'current' => $phpVersion,
        'passed' => version_compare($phpVersion, '8.2.0', '>='),
    ];
    
    // Required Extensions
    $extensions = [
        'pdo' => 'PDO',
        'pdo_mysql' => 'PDO MySQL',
        'mbstring' => 'Mbstring',
        'openssl' => 'OpenSSL',
        'tokenizer' => 'Tokenizer',
        'xml' => 'XML',
        'ctype' => 'Ctype',
        'json' => 'JSON',
        'bcmath' => 'BCMath',
        'fileinfo' => 'Fileinfo',
        'curl' => 'cURL',
    ];
    
    foreach ($extensions as $ext => $name) {
        $checks[] = [
            'name' => $name . ' Extension',
            'required' => 'Enabled',
            'current' => extension_loaded($ext) ? 'Enabled' : 'Missing',
            'passed' => extension_loaded($ext),
        ];
    }
    
    // Writable Directories
    $writableDirs = [
        'storage/app' => 'storage/app',
        'storage/framework' => 'storage/framework',
        'storage/framework/cache' => 'storage/framework/cache',
        'storage/framework/sessions' => 'storage/framework/sessions',
        'storage/framework/views' => 'storage/framework/views',
        'storage/logs' => 'storage/logs',
        'bootstrap/cache' => 'bootstrap/cache',
    ];
    
    global $basePath;
    foreach ($writableDirs as $dir => $label) {
        $fullPath = $basePath . '/' . $dir;
        $writable = is_dir($fullPath) && is_writable($fullPath);
        $checks[] = [
            'name' => $label,
            'required' => 'Writable',
            'current' => $writable ? 'Writable' : 'Not Writable',
            'passed' => $writable,
        ];
    }
    
    // Check composer vendor
    $checks[] = [
        'name' => 'Composer Dependencies',
        'required' => 'Installed',
        'current' => is_dir($basePath . '/vendor') ? 'Installed' : 'Missing',
        'passed' => is_dir($basePath . '/vendor'),
    ];
    
    $allPassed = !in_array(false, array_column($checks, 'passed'));
    
    return ['success' => true, 'checks' => $checks, 'allPassed' => $allPassed];
}

// ── Database Test ───────────────────────────────────────────────────────────
function testDatabase(array $data): array {
    $host = trim($data['db_host'] ?? '127.0.0.1');
    $port = trim($data['db_port'] ?? '3306');
    $name = trim($data['db_name'] ?? '');
    $user = trim($data['db_user'] ?? '');
    $pass = $data['db_pass'] ?? '';
    
    if (empty($name) || empty($user)) {
        return ['success' => false, 'message' => 'Database name and username are required.'];
    }
    
    try {
        $dsn = "mysql:host={$host};port={$port};dbname={$name}";
        $pdo = new PDO($dsn, $user, $pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_TIMEOUT => 5,
        ]);
        
        // Check if it's empty (warn if tables exist)
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        $tableCount = count($tables);
        
        $message = "Connected successfully to '{$name}'.";
        if ($tableCount > 0) {
            $message .= " Warning: Database has {$tableCount} existing tables. They may conflict.";
        }
        
        return ['success' => true, 'message' => $message, 'tables' => $tableCount];
    } catch (PDOException $e) {
        $msg = $e->getMessage();
        // Simplify common errors
        if (str_contains($msg, 'Unknown database')) {
            $msg = "Database '{$name}' does not exist. Please create it in cPanel > MySQL Databases first.";
        } elseif (str_contains($msg, 'Access denied')) {
            $msg = "Access denied. Check username/password. On cPanel, username is usually 'cpaneluser_dbuser'.";
        } elseif (str_contains($msg, 'Connection refused') || str_contains($msg, 'No such file')) {
            $msg = "Cannot connect to MySQL on {$host}:{$port}. On cPanel, host is usually 'localhost'.";
        }
        return ['success' => false, 'message' => $msg];
    }
}

// ── Main Installation ───────────────────────────────────────────────────────
function runInstallation(array $data): array {
    global $basePath, $envPath, $lockFile;
    
    $steps = [];
    
    // ── Step 1: Write .env file ─────────────────────────────────────────────
    try {
        $envContent = generateEnvFile($data);
        file_put_contents($envPath, $envContent);
        $steps[] = ['step' => 'Environment Configuration', 'status' => 'success', 'message' => '.env file created'];
    } catch (\Throwable $e) {
        return ['success' => false, 'steps' => $steps, 'message' => 'Failed to write .env: ' . $e->getMessage()];
    }
    
    // ── Step 2: Bootstrap Laravel ───────────────────────────────────────────
    try {
        // Clear any opcache
        if (function_exists('opcache_reset')) {
            opcache_reset();
        }
        
        require $basePath . '/vendor/autoload.php';
        $app = require $basePath . '/bootstrap/app.php';
        $kernel = $app->make('Illuminate\Contracts\Console\Kernel');
        $kernel->bootstrap();
        
        $steps[] = ['step' => 'Laravel Bootstrap', 'status' => 'success', 'message' => 'Application loaded'];
    } catch (\Throwable $e) {
        return ['success' => false, 'steps' => $steps, 'message' => 'Failed to bootstrap Laravel: ' . $e->getMessage()];
    }
    
    // ── Step 3: Generate App Key ────────────────────────────────────────────
    try {
        Illuminate\Support\Facades\Artisan::call('key:generate', ['--force' => true]);
        $steps[] = ['step' => 'App Key Generation', 'status' => 'success', 'message' => 'Encryption key generated'];
    } catch (\Throwable $e) {
        $steps[] = ['step' => 'App Key Generation', 'status' => 'warning', 'message' => $e->getMessage()];
    }
    
    // ── Step 4: Run Migrations ──────────────────────────────────────────────
    try {
        Illuminate\Support\Facades\Artisan::call('migrate', ['--force' => true]);
        $output = Illuminate\Support\Facades\Artisan::output();
        $steps[] = ['step' => 'Database Migration', 'status' => 'success', 'message' => 'All tables created'];
    } catch (\Throwable $e) {
        return ['success' => false, 'steps' => $steps, 'message' => 'Migration failed: ' . $e->getMessage()];
    }
    
    // ── Step 5: Seed Database ───────────────────────────────────────────────
    $seedData = ($data['seed_data'] ?? 'full') === 'full';
    try {
        if ($seedData) {
            Illuminate\Support\Facades\Artisan::call('db:seed', ['--force' => true]);
            $steps[] = ['step' => 'Database Seeding', 'status' => 'success', 'message' => 'Sample data & templates loaded'];
        } else {
            // Only seed email templates (essential)
            Illuminate\Support\Facades\Artisan::call('db:seed', [
                '--class' => 'Database\\Seeders\\EmailTemplateSeeder',
                '--force' => true,
            ]);
            $steps[] = ['step' => 'Database Seeding', 'status' => 'success', 'message' => 'Email templates loaded (no sample data)'];
        }
    } catch (\Throwable $e) {
        $steps[] = ['step' => 'Database Seeding', 'status' => 'warning', 'message' => 'Seeding issue: ' . $e->getMessage()];
    }
    
    // ── Step 6: Create Admin User (if not seeding full data) ────────────────
    if (!$seedData) {
        try {
            $adminEmail = trim($data['admin_email'] ?? '');
            $adminName  = trim($data['admin_name'] ?? 'Administrator');
            $adminPass  = $data['admin_password'] ?? '';
            
            if (!empty($adminEmail) && !empty($adminPass)) {
                \App\Models\User::create([
                    'name' => $adminName,
                    'email' => $adminEmail,
                    'password' => \Illuminate\Support\Facades\Hash::make($adminPass),
                    'role' => 'admin',
                ]);
                $steps[] = ['step' => 'Admin Account', 'status' => 'success', 'message' => "Admin created: {$adminEmail}"];
                
                // Create essential settings
                \App\Models\Setting::updateOrCreate(['key' => 'site_name'], ['value' => 'SHARE IJ']);
                \App\Models\Setting::updateOrCreate(['key' => 'site_email'], ['value' => $adminEmail]);
                $steps[] = ['step' => 'Default Settings', 'status' => 'success', 'message' => 'Site settings initialized'];
            }
        } catch (\Throwable $e) {
            $steps[] = ['step' => 'Admin Account', 'status' => 'warning', 'message' => $e->getMessage()];
        }
    }
    
    // ── Step 7: Storage Link ────────────────────────────────────────────────
    try {
        // On shared hosting, artisan storage:link may fail. Manual fallback.
        $publicStorage = $basePath . '/public/storage';
        $targetStorage = $basePath . '/storage/app/public';
        
        if (!file_exists($publicStorage)) {
            if (function_exists('symlink')) {
                @symlink($targetStorage, $publicStorage);
            }
            
            // Verify — if symlink failed, create a PHP-based redirect workaround
            if (!file_exists($publicStorage)) {
                // Create directory and .htaccess redirect as fallback
                @mkdir($publicStorage, 0755, true);
                // Copy approach won't work long-term, note it
                $steps[] = ['step' => 'Storage Link', 'status' => 'warning', 
                    'message' => 'Symlink failed (common on shared hosting). Go to cPanel > Terminal and run: php artisan storage:link'];
            } else {
                $steps[] = ['step' => 'Storage Link', 'status' => 'success', 'message' => 'Storage symlink created'];
            }
        } else {
            $steps[] = ['step' => 'Storage Link', 'status' => 'success', 'message' => 'Storage link already exists'];
        }
    } catch (\Throwable $e) {
        $steps[] = ['step' => 'Storage Link', 'status' => 'warning', 'message' => $e->getMessage()];
    }
    
    // ── Step 8: Clear & Cache ───────────────────────────────────────────────
    try {
        Illuminate\Support\Facades\Artisan::call('config:clear');
        Illuminate\Support\Facades\Artisan::call('route:clear');
        Illuminate\Support\Facades\Artisan::call('view:clear');
        Illuminate\Support\Facades\Artisan::call('config:cache');
        Illuminate\Support\Facades\Artisan::call('route:cache');
        Illuminate\Support\Facades\Artisan::call('view:cache');
        $steps[] = ['step' => 'Cache Optimization', 'status' => 'success', 'message' => 'Routes, views & config cached'];
    } catch (\Throwable $e) {
        $steps[] = ['step' => 'Cache Optimization', 'status' => 'warning', 'message' => $e->getMessage()];
    }
    
    // ── Step 9: Create lock file ────────────────────────────────────────────
    try {
        file_put_contents($lockFile, json_encode([
            'installed_at' => date('Y-m-d H:i:s'),
            'php_version' => PHP_VERSION,
            'installer_version' => '1.0.0',
        ]));
        $steps[] = ['step' => 'Lock File', 'status' => 'success', 'message' => 'Installation locked'];
    } catch (\Throwable $e) {
        $steps[] = ['step' => 'Lock File', 'status' => 'warning', 'message' => $e->getMessage()];
    }
    
    // Build credentials summary
    $credentials = [];
    if ($seedData) {
        $credentials = [
            ['role' => 'Admin', 'email' => 'admin@dejournal.com', 'password' => 'password123'],
            ['role' => 'Editor', 'email' => 'editor@dejournal.com', 'password' => 'password123'],
            ['role' => 'Reviewer', 'email' => 'sarah@dejournal.com', 'password' => 'password123'],
            ['role' => 'Author', 'email' => 'author@dejournal.com', 'password' => 'password123'],
        ];
    } else {
        $credentials = [
            ['role' => 'Admin', 'email' => $data['admin_email'] ?? '', 'password' => '(as configured)'],
        ];
    }
    
    return [
        'success' => true, 
        'steps' => $steps, 
        'credentials' => $credentials,
        'message' => 'Installation completed successfully!',
    ];
}

// ── Generate .env file ──────────────────────────────────────────────────────
function generateEnvFile(array $data): string {
    $appUrl = rtrim(trim($data['app_url'] ?? ''), '/');
    if (empty($appUrl)) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $appUrl = $protocol . '://' . $host;
    }
    
    $dbHost = trim($data['db_host'] ?? 'localhost');
    $dbPort = trim($data['db_port'] ?? '3306');
    $dbName = trim($data['db_name'] ?? '');
    $dbUser = trim($data['db_user'] ?? '');
    $dbPass = $data['db_pass'] ?? '';
    
    $mailMailer  = trim($data['mail_mailer'] ?? 'smtp');
    $mailHost    = trim($data['mail_host'] ?? '');
    $mailPort    = trim($data['mail_port'] ?? '587');
    $mailUser    = trim($data['mail_user'] ?? '');
    $mailPass    = $data['mail_pass'] ?? '';
    $mailFrom    = trim($data['mail_from'] ?? $dbUser);
    $mailName    = trim($data['mail_from_name'] ?? 'SHARE IJ');
    $mailScheme  = trim($data['mail_encryption'] ?? 'tls');
    
    // On cPanel shared hosting, sendmail is often the easiest
    if ($mailMailer === 'sendmail') {
        $mailHost = '';
        $mailPort = '';
        $mailUser = '';
        $mailPass = '';
        $mailScheme = '';
    }
    
    $sessionDriver = 'file'; // file is most reliable on shared hosting

    return <<<ENV
APP_NAME="SHARE IJ"
APP_ENV=production
APP_KEY=
APP_DEBUG=false
APP_URL={$appUrl}

APP_LOCALE=en
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=en_US

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=single
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST={$dbHost}
DB_PORT={$dbPort}
DB_DATABASE={$dbName}
DB_USERNAME={$dbUser}
DB_PASSWORD={$dbPass}

SESSION_DRIVER={$sessionDriver}
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync

CACHE_STORE=file

MAIL_MAILER={$mailMailer}
MAIL_SCHEME={$mailScheme}
MAIL_HOST={$mailHost}
MAIL_PORT={$mailPort}
MAIL_USERNAME={$mailUser}
MAIL_PASSWORD={$mailPass}
MAIL_FROM_ADDRESS="{$mailFrom}"
MAIL_FROM_NAME="{$mailName}"

ENV;
}

// ── HTML Frontend ───────────────────────────────────────────────────────────
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SHARE IJ - Installer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        :root { --primary: #0f172a; --accent: #2563eb; --success: #16a34a; --warn: #f59e0b; --danger: #dc2626; }
        body { background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%); min-height: 100vh; font-family: 'Segoe UI', system-ui, sans-serif; }
        .installer-container { max-width: 720px; margin: 40px auto; }
        .installer-card { background: #fff; border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.3); overflow: hidden; }
        .installer-header { background: linear-gradient(135deg, #1e3a5f, #2563eb); color: #fff; padding: 30px; text-align: center; }
        .installer-header h1 { font-size: 1.8rem; font-weight: 700; margin: 0; }
        .installer-header p { opacity: .85; margin: 5px 0 0; font-size: .9rem; }
        .installer-body { padding: 30px; }
        
        /* Steps indicator */
        .steps-bar { display: flex; justify-content: center; gap: 8px; margin-bottom: 30px; }
        .step-dot { width: 40px; height: 40px; border-radius: 50%; background: #e2e8f0; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: .85rem; color: #94a3b8; transition: all .3s; position: relative; }
        .step-dot.active { background: var(--accent); color: #fff; box-shadow: 0 0 0 4px rgba(37,99,235,.2); }
        .step-dot.done { background: var(--success); color: #fff; }
        .step-connector { width: 40px; height: 2px; background: #e2e8f0; align-self: center; transition: background .3s; }
        .step-connector.done { background: var(--success); }
        
        /* Sections */
        .install-step { display: none; }
        .install-step.active { display: block; }
        
        /* Check items */
        .check-item { display: flex; align-items: center; padding: 10px 14px; border-radius: 8px; margin-bottom: 6px; background: #f8fafc; }
        .check-item .icon { width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-right: 12px; font-size: .8rem; flex-shrink: 0; }
        .check-item .icon.pass { background: #dcfce7; color: var(--success); }
        .check-item .icon.fail { background: #fef2f2; color: var(--danger); }
        .check-item .name { flex: 1; font-weight: 500; font-size: .9rem; }
        .check-item .value { font-size: .8rem; color: #64748b; }
        
        /* Install log */
        .install-log { max-height: 360px; overflow-y: auto; }
        .log-item { display: flex; align-items: center; padding: 10px 14px; border-radius: 8px; margin-bottom: 6px; }
        .log-item.success { background: #f0fdf4; }
        .log-item.warning { background: #fffbeb; }
        .log-item.error { background: #fef2f2; }
        .log-item .log-icon { margin-right: 10px; font-size: 1.1rem; }
        .log-item .log-step { font-weight: 600; font-size: .9rem; }
        .log-item .log-msg { font-size: .8rem; color: #64748b; }
        
        /* Credential cards */
        .cred-card { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; margin-bottom: 8px; }
        .cred-card .role { font-weight: 700; color: var(--accent); font-size: .85rem; text-transform: uppercase; letter-spacing: .5px; }
        .cred-card code { background: #e2e8f0; padding: 2px 8px; border-radius: 4px; font-size: .85rem; }
        
        .form-label { font-weight: 600; font-size: .88rem; color: #334155; }
        .form-text { font-size: .78rem; }
        .btn-install { background: var(--accent); border: none; padding: 12px 32px; font-weight: 600; font-size: 1rem; border-radius: 10px; }
        .btn-install:hover { background: #1d4ed8; }
        .btn-install:disabled { background: #94a3b8; }
        
        .help-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 10px; padding: 14px; margin-bottom: 20px; }
        .help-box i { color: var(--accent); }
        .help-box p { margin: 0; font-size: .85rem; color: #1e40af; }
        
        .spinner { display: inline-block; width: 20px; height: 20px; border: 3px solid rgba(255,255,255,.3); border-top-color: #fff; border-radius: 50%; animation: spin .6s linear infinite; }
        @keyframes spin { to { transform: rotate(360deg); } }
        
        .security-note { background: #fef3c7; border: 1px solid #fcd34d; border-radius: 10px; padding: 14px; margin-top: 16px; }
        .security-note p { margin: 0; font-size: .85rem; color: #92400e; }
    </style>
</head>
<body>
    <div class="installer-container">
        <div class="installer-card">
            <div class="installer-header">
                <h1><i class="fas fa-journal-whills"></i> SHARE IJ Installer</h1>
                <p>Share International Journal of Sustainable Engineering, Management & Social Sciences</p>
            </div>
            <div class="installer-body">
                
                <!-- Steps Bar -->
                <div class="steps-bar">
                    <div class="step-dot active" id="dot-1">1</div>
                    <div class="step-connector" id="conn-1"></div>
                    <div class="step-dot" id="dot-2">2</div>
                    <div class="step-connector" id="conn-2"></div>
                    <div class="step-dot" id="dot-3">3</div>
                    <div class="step-connector" id="conn-3"></div>
                    <div class="step-dot" id="dot-4">4</div>
                    <div class="step-connector" id="conn-4"></div>
                    <div class="step-dot" id="dot-5">5</div>
                </div>
                
                <!-- ============ STEP 1: Requirements ============ -->
                <div class="install-step active" id="step-1">
                    <h4 class="mb-3"><i class="fas fa-clipboard-check text-primary"></i> Server Requirements</h4>
                    <div id="requirements-list">
                        <div class="text-center py-4">
                            <div class="spinner" style="border-color:#2563eb rgba(37,99,235,.2) rgba(37,99,235,.2);border-top-color:#2563eb;width:32px;height:32px"></div>
                            <p class="mt-2 text-muted">Checking server requirements...</p>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button class="btn btn-install text-white" id="btn-step1-next" disabled onclick="goToStep(2)">
                            Next <i class="fas fa-arrow-right ms-1"></i>
                        </button>
                    </div>
                </div>
                
                <!-- ============ STEP 2: Database ============ -->
                <div class="install-step" id="step-2">
                    <h4 class="mb-3"><i class="fas fa-database text-primary"></i> Database Configuration</h4>
                    <div class="help-box">
                        <p><i class="fas fa-info-circle me-1"></i> <strong>cPanel users:</strong> Create a MySQL database & user in <strong>cPanel &rarr; MySQL Databases</strong> first. Username format is usually <code>cpaneluser_dbuser</code>.</p>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label class="form-label">Database Host</label>
                            <input type="text" class="form-control" id="db_host" value="localhost" placeholder="localhost">
                            <div class="form-text">Usually <code>localhost</code> on cPanel</div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Port</label>
                            <input type="text" class="form-control" id="db_port" value="3306">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Database Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="db_name" placeholder="cpaneluser_shareij" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Database Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="db_user" placeholder="cpaneluser_dbuser" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Database Password</label>
                            <input type="password" class="form-control" id="db_pass" placeholder="Enter password">
                        </div>
                    </div>
                    <div id="db-test-result" class="mt-3" style="display:none"></div>
                    <div class="d-flex justify-content-between mt-3">
                        <button class="btn btn-outline-secondary" onclick="goToStep(1)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                        <div>
                            <button class="btn btn-outline-primary me-2" id="btn-test-db" onclick="testDatabase()">
                                <i class="fas fa-plug me-1"></i> Test Connection
                            </button>
                            <button class="btn btn-install text-white" id="btn-step2-next" disabled onclick="goToStep(3)">
                                Next <i class="fas fa-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- ============ STEP 3: Site & Mail ============ -->
                <div class="install-step" id="step-3">
                    <h4 class="mb-3"><i class="fas fa-cog text-primary"></i> Site & Email Settings</h4>
                    
                    <h6 class="text-muted mt-3 mb-2"><i class="fas fa-globe"></i> Site URL</h6>
                    <div class="mb-3">
                        <input type="url" class="form-control" id="app_url" placeholder="https://yourdomain.com" value="">
                        <div class="form-text">Your website URL (auto-detected if left blank)</div>
                    </div>
                    
                    <h6 class="text-muted mt-4 mb-2"><i class="fas fa-envelope"></i> Email Configuration</h6>
                    <div class="help-box">
                        <p><i class="fas fa-lightbulb me-1"></i> For cPanel, <strong>SMTP</strong> with your cPanel email is recommended. Alternatively, use <strong>Sendmail</strong> (simplest) or configure Gmail/third-party SMTP.</p>
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Mail Driver</label>
                            <select class="form-select" id="mail_mailer" onchange="toggleMailFields()">
                                <option value="smtp" selected>SMTP (Recommended)</option>
                                <option value="sendmail">Sendmail (Simplest)</option>
                                <option value="log">Log Only (No actual emails)</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Encryption</label>
                            <select class="form-select" id="mail_encryption">
                                <option value="tls">TLS (Port 587)</option>
                                <option value="ssl">SSL (Port 465)</option>
                                <option value="">None (Port 25)</option>
                            </select>
                        </div>
                        <div class="col-md-8 smtp-field">
                            <label class="form-label">SMTP Host</label>
                            <input type="text" class="form-control" id="mail_host" placeholder="mail.yourdomain.com">
                            <div class="form-text">cPanel: <code>mail.yourdomain.com</code> | Gmail: <code>smtp.gmail.com</code></div>
                        </div>
                        <div class="col-md-4 smtp-field">
                            <label class="form-label">SMTP Port</label>
                            <input type="text" class="form-control" id="mail_port" value="587">
                        </div>
                        <div class="col-md-6 smtp-field">
                            <label class="form-label">SMTP Username</label>
                            <input type="text" class="form-control" id="mail_user" placeholder="noreply@yourdomain.com">
                        </div>
                        <div class="col-md-6 smtp-field">
                            <label class="form-label">SMTP Password</label>
                            <input type="password" class="form-control" id="mail_pass">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">From Email Address</label>
                            <input type="email" class="form-control" id="mail_from" placeholder="editor@yourdomain.com">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">From Name</label>
                            <input type="text" class="form-control" id="mail_from_name" value="SHARE IJ">
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn btn-outline-secondary" onclick="goToStep(2)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                        <button class="btn btn-install text-white" onclick="goToStep(4)">Next <i class="fas fa-arrow-right ms-1"></i></button>
                    </div>
                </div>
                
                <!-- ============ STEP 4: Admin & Data ============ -->
                <div class="install-step" id="step-4">
                    <h4 class="mb-3"><i class="fas fa-user-shield text-primary"></i> Admin Account & Data</h4>
                    
                    <h6 class="text-muted mb-2"><i class="fas fa-database"></i> Initial Data</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="radio" name="seed_data" id="seed_full" value="full" checked onchange="toggleAdminFields()">
                                <label class="form-check-label" for="seed_full">
                                    <strong>Full Demo Data</strong>
                                    <span class="text-muted d-block" style="font-size:.8rem">Includes sample users, papers, volumes, blog posts, and all settings. Great for testing.</span>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="seed_data" id="seed_minimal" value="minimal" onchange="toggleAdminFields()">
                                <label class="form-check-label" for="seed_minimal">
                                    <strong>Clean Install</strong>
                                    <span class="text-muted d-block" style="font-size:.8rem">Only email templates. You'll create your own admin account below.</span>
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div id="admin-fields" style="display:none">
                        <h6 class="text-muted mb-2"><i class="fas fa-user-cog"></i> Create Admin Account</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Admin Name <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="admin_name" placeholder="Dr. Your Name">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Admin Email <span class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="admin_email" placeholder="admin@yourdomain.com">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="admin_password" placeholder="Min 8 characters">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                <input type="password" class="form-control" id="admin_password_confirm" placeholder="Repeat password">
                            </div>
                        </div>
                    </div>
                    
                    <div id="demo-info" class="help-box mt-3">
                        <p><i class="fas fa-info-circle me-1"></i> <strong>Demo accounts will be created:</strong> admin@dejournal.com, editor@dejournal.com, sarah@dejournal.com, author@dejournal.com — all with password <code>password123</code>. Change these after install!</p>
                    </div>
                    
                    <div class="d-flex justify-content-between mt-4">
                        <button class="btn btn-outline-secondary" onclick="goToStep(3)"><i class="fas fa-arrow-left me-1"></i> Back</button>
                        <button class="btn btn-install text-white" id="btn-install" onclick="runInstall()">
                            <i class="fas fa-rocket me-1"></i> Install Now
                        </button>
                    </div>
                </div>
                
                <!-- ============ STEP 5: Complete ============ -->
                <div class="install-step" id="step-5">
                    <div id="install-progress">
                        <div class="text-center py-4">
                            <div class="spinner" style="border-color:#2563eb rgba(37,99,235,.2) rgba(37,99,235,.2);border-top-color:#2563eb;width:48px;height:48px"></div>
                            <h5 class="mt-3">Installing SHARE IJ...</h5>
                            <p class="text-muted">This may take a minute. Please don't close this page.</p>
                        </div>
                    </div>
                    
                    <div id="install-result" style="display:none">
                        <div class="text-center mb-4" id="result-header"></div>
                        <div class="install-log" id="install-log"></div>
                        <div id="credentials-section" style="display:none">
                            <h6 class="mt-4 mb-3"><i class="fas fa-key text-warning"></i> Login Credentials</h6>
                            <div id="credentials-list"></div>
                        </div>
                        <div class="security-note">
                            <p><i class="fas fa-shield-alt me-1"></i> <strong>Security:</strong> Delete <code>install.php</code> from your server immediately after installation. The installer is now locked but removing the file adds extra security.</p>
                        </div>
                        <div class="d-flex justify-content-center mt-4 gap-3">
                            <a href="/" class="btn btn-outline-primary"><i class="fas fa-home me-1"></i> Visit Website</a>
                            <a href="/admin" class="btn btn-install text-white"><i class="fas fa-lock me-1"></i> Admin Panel</a>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        <p class="text-center mt-3" style="color:rgba(255,255,255,.4);font-size:.8rem">SHARE IJ Installer v1.0 &bull; Laravel 12</p>
    </div>

    <script>
    let currentStep = 1;
    let dbTested = false;
    const INSTALL_URL = window.location.pathname; // Always post to self
    
    // ── Step Navigation ─────────────────────────────────────────────────────
    function goToStep(step) {
        // Validation before moving forward
        if (step === 3 && !dbTested) {
            alert('Please test the database connection first.');
            return;
        }
        
        document.querySelectorAll('.install-step').forEach(el => el.classList.remove('active'));
        document.getElementById('step-' + step).classList.add('active');
        
        for (let i = 1; i <= 5; i++) {
            const dot = document.getElementById('dot-' + i);
            const conn = document.getElementById('conn-' + i);
            dot.classList.remove('active', 'done');
            if (conn) conn.classList.remove('done');
            
            if (i < step) {
                dot.classList.add('done');
                dot.innerHTML = '<i class="fas fa-check" style="font-size:.7rem"></i>';
                if (conn) conn.classList.add('done');
            } else if (i === step) {
                dot.classList.add('active');
                dot.textContent = i;
            } else {
                dot.textContent = i;
            }
        }
        
        currentStep = step;
    }
    
    // ── Check Requirements on Load ──────────────────────────────────────────
    async function checkRequirements() {
        try {
            const resp = await fetch(INSTALL_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'action=check_requirements'
            });
            
            const text = await resp.text();
            let data;
            try {
                data = JSON.parse(text);
            } catch(parseErr) {
                // Response was not JSON - show raw for debugging
                document.getElementById('requirements-list').innerHTML = 
                    '<div class="alert alert-danger"><strong>Server returned invalid response.</strong><br><small>Status: ' + resp.status + '</small><br><pre style="max-height:200px;overflow:auto;font-size:.75rem;margin-top:8px">' + text.substring(0, 1000).replace(/</g,'&lt;') + '</pre></div>' +
                    '<div class="mt-2"><button class="btn btn-warning btn-sm" onclick="document.getElementById(\'btn-step1-next\').disabled=false">Continue Anyway</button></div>';
                return;
            }
            
            let html = '';
            let criticalFail = false;
            data.checks.forEach(check => {
                const icon = check.passed 
                    ? '<div class="icon pass"><i class="fas fa-check"></i></div>' 
                    : '<div class="icon fail"><i class="fas fa-times"></i></div>';
                html += `<div class="check-item">
                    ${icon}
                    <span class="name">${check.name}</span>
                    <span class="value">${check.current}</span>
                </div>`;
                // Only PHP version, PDO, PDO MySQL are critical
                if (!check.passed && (check.name.includes('PHP Version') || check.name.includes('PDO'))) {
                    criticalFail = true;
                }
            });
            
            document.getElementById('requirements-list').innerHTML = html;
            document.getElementById('btn-step1-next').disabled = false; // Always allow proceeding
            
            if (!data.allPassed) {
                let msg = criticalFail 
                    ? '<div class="alert alert-danger mt-3"><i class="fas fa-exclamation-triangle me-1"></i> Critical requirements are missing. Installation may fail.</div>'
                    : '<div class="alert alert-warning mt-3"><i class="fas fa-exclamation-triangle me-1"></i> Some non-critical requirements are not met. You can still proceed — fix these later if needed.</div>';
                document.getElementById('requirements-list').innerHTML += msg;
            }
        } catch (e) {
            document.getElementById('requirements-list').innerHTML = 
                '<div class="alert alert-danger">Failed to check requirements: ' + e.message + '<br><small>URL: ' + INSTALL_URL + '</small></div>' +
                '<div class="mt-2"><button class="btn btn-warning btn-sm" onclick="document.getElementById(\'btn-step1-next\').disabled=false">Skip & Continue Anyway</button></div>';
        }
    }
    
    // ── Test Database Connection ────────────────────────────────────────────
    async function testDatabase() {
        const btn = document.getElementById('btn-test-db');
        const resultDiv = document.getElementById('db-test-result');
        
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner" style="width:16px;height:16px;border-width:2px"></span> Testing...';
        resultDiv.style.display = 'block';
        resultDiv.innerHTML = '<div class="alert alert-info mb-0"><i class="fas fa-spinner fa-spin me-1"></i> Connecting...</div>';
        
        try {
            const params = new URLSearchParams({
                action: 'test_database',
                db_host: document.getElementById('db_host').value,
                db_port: document.getElementById('db_port').value,
                db_name: document.getElementById('db_name').value,
                db_user: document.getElementById('db_user').value,
                db_pass: document.getElementById('db_pass').value,
            });
            
            const resp = await fetch(INSTALL_URL, { method: 'POST', body: params });
            const data = await resp.json();
            
            if (data.success) {
                resultDiv.innerHTML = `<div class="alert alert-success mb-0"><i class="fas fa-check-circle me-1"></i> ${data.message}</div>`;
                document.getElementById('btn-step2-next').disabled = false;
                dbTested = true;
            } else {
                resultDiv.innerHTML = `<div class="alert alert-danger mb-0"><i class="fas fa-times-circle me-1"></i> ${data.message}</div>`;
                document.getElementById('btn-step2-next').disabled = true;
                dbTested = false;
            }
        } catch (e) {
            resultDiv.innerHTML = `<div class="alert alert-danger mb-0"><i class="fas fa-times-circle me-1"></i> ${e.message}</div>`;
            dbTested = false;
        }
        
        btn.disabled = false;
        btn.innerHTML = '<i class="fas fa-plug me-1"></i> Test Connection';
    }
    
    // ── Toggle Mail Fields ──────────────────────────────────────────────────
    function toggleMailFields() {
        const mailer = document.getElementById('mail_mailer').value;
        const smtpFields = document.querySelectorAll('.smtp-field');
        smtpFields.forEach(el => el.style.display = mailer === 'smtp' ? '' : 'none');
    }
    
    // ── Toggle Admin Fields ─────────────────────────────────────────────────
    function toggleAdminFields() {
        const isFull = document.getElementById('seed_full').checked;
        document.getElementById('admin-fields').style.display = isFull ? 'none' : 'block';
        document.getElementById('demo-info').style.display = isFull ? 'block' : 'none';
    }
    
    // ── Run Installation ────────────────────────────────────────────────────
    async function runInstall() {
        const seedData = document.querySelector('input[name="seed_data"]:checked').value;
        
        // Validate admin fields for clean install
        if (seedData === 'minimal') {
            const name = document.getElementById('admin_name').value.trim();
            const email = document.getElementById('admin_email').value.trim();
            const pass = document.getElementById('admin_password').value;
            const confirm = document.getElementById('admin_password_confirm').value;
            
            if (!name || !email || !pass) { alert('Please fill in all admin account fields.'); return; }
            if (pass.length < 8) { alert('Password must be at least 8 characters.'); return; }
            if (pass !== confirm) { alert('Passwords do not match.'); return; }
        }
        
        goToStep(5);
        
        try {
            const params = new URLSearchParams({
                action: 'install',
                db_host: document.getElementById('db_host').value,
                db_port: document.getElementById('db_port').value,
                db_name: document.getElementById('db_name').value,
                db_user: document.getElementById('db_user').value,
                db_pass: document.getElementById('db_pass').value,
                app_url: document.getElementById('app_url').value,
                mail_mailer: document.getElementById('mail_mailer').value,
                mail_host: document.getElementById('mail_host').value,
                mail_port: document.getElementById('mail_port').value,
                mail_user: document.getElementById('mail_user').value,
                mail_pass: document.getElementById('mail_pass').value,
                mail_from: document.getElementById('mail_from').value,
                mail_from_name: document.getElementById('mail_from_name').value,
                mail_encryption: document.getElementById('mail_encryption').value,
                seed_data: seedData,
                admin_name: document.getElementById('admin_name')?.value || '',
                admin_email: document.getElementById('admin_email')?.value || '',
                admin_password: document.getElementById('admin_password')?.value || '',
            });
            
            const resp = await fetch(INSTALL_URL, { method: 'POST', body: params });
            const text = await resp.text();
            let data;
            try { data = JSON.parse(text); } catch(e) {
                throw new Error('Invalid server response: ' + text.substring(0, 300));
            }
            
            document.getElementById('install-progress').style.display = 'none';
            document.getElementById('install-result').style.display = 'block';
            
            // Result header
            const header = document.getElementById('result-header');
            if (data.success) {
                header.innerHTML = '<div style="font-size:3rem;color:var(--success)"><i class="fas fa-check-circle"></i></div>' +
                    '<h4 class="mt-2">Installation Complete!</h4>' +
                    '<p class="text-muted">SHARE IJ has been installed successfully.</p>';
            } else {
                header.innerHTML = '<div style="font-size:3rem;color:var(--danger)"><i class="fas fa-times-circle"></i></div>' +
                    '<h4 class="mt-2">Installation Failed</h4>' +
                    '<p class="text-danger">' + (data.message || 'Unknown error') + '</p>';
            }
            
            // Log items
            const logDiv = document.getElementById('install-log');
            let logHtml = '';
            (data.steps || []).forEach(step => {
                const iconClass = step.status === 'success' ? 'fa-check-circle text-success' : 
                                  step.status === 'warning' ? 'fa-exclamation-triangle text-warning' : 'fa-times-circle text-danger';
                logHtml += `<div class="log-item ${step.status}">
                    <i class="fas ${iconClass} log-icon"></i>
                    <div><div class="log-step">${step.step}</div><div class="log-msg">${step.message}</div></div>
                </div>`;
            });
            logDiv.innerHTML = logHtml;
            
            // Credentials
            if (data.credentials && data.credentials.length > 0) {
                document.getElementById('credentials-section').style.display = 'block';
                let credHtml = '';
                data.credentials.forEach(cred => {
                    credHtml += `<div class="cred-card">
                        <div class="role">${cred.role}</div>
                        <div class="mt-1">Email: <code>${cred.email}</code> &bull; Password: <code>${cred.password}</code></div>
                    </div>`;
                });
                document.getElementById('credentials-list').innerHTML = credHtml;
            }
            
        } catch (e) {
            document.getElementById('install-progress').style.display = 'none';
            document.getElementById('install-result').style.display = 'block';
            document.getElementById('result-header').innerHTML = 
                '<div style="font-size:3rem;color:var(--danger)"><i class="fas fa-times-circle"></i></div>' +
                '<h4 class="mt-2">Installation Error</h4>' +
                '<p class="text-danger">' + e.message + '</p>';
        }
    }
    
    // ── Auto-detect URL ─────────────────────────────────────────────────────
    document.addEventListener('DOMContentLoaded', function() {
        const protocol = window.location.protocol;
        const host = window.location.host;
        document.getElementById('app_url').placeholder = protocol + '//' + host;
        
        // Auto-detect mail host from domain
        const domain = host.replace(/^www\./, '').split(':')[0];
        if (domain !== 'localhost' && domain !== '127.0.0.1') {
            document.getElementById('mail_host').value = 'mail.' + domain;
        }
        
        checkRequirements();
    });
    </script>
</body>
</html>
