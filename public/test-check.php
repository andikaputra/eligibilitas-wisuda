<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "<h2>1. PHP Version: " . phpversion() . "</h2>";

$vendor = __DIR__ . '/../vendor/autoload.php';
echo "<p>2. Checking vendor autoload (" . realpath($vendor) . "): <b>" . (file_exists($vendor) ? "<span style='color:green'>FOUND</span>" : "<span style='color:red'>NOT FOUND</span>") . "</b></p>";

$bootstrap = __DIR__ . '/../bootstrap/app.php';
echo "<p>3. Checking bootstrap app (" . realpath($bootstrap) . "): <b>" . (file_exists($bootstrap) ? "<span style='color:green'>FOUND</span>" : "<span style='color:red'>NOT FOUND</span>") . "</b></p>";

$env = __DIR__ . '/../.env';
echo "<p>4. Checking .env (" . realpath($env) . "): <b>" . (file_exists($env) ? "<span style='color:green'>FOUND</span>" : "<span style='color:red'>NOT FOUND</span>") . "</b></p>";

echo "<h3>5. Running Bootstrap Test...</h3>";
try {
    require $vendor;
    echo "<p style='color:green'>✓ Vendor autoloader loaded successfully!</p>";

    $app = require_once $bootstrap;
    echo "<p style='color:green'>✓ Laravel application bootstrapped successfully!</p>";

    $kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
    $kernel->bootstrap();
    echo "<p style='color:green'>✓ Laravel Kernel bootstrapped successfully! Everything is working!</p>";
} catch (\Throwable $e) {
    echo "<div style='background:#fee;color:#c00;padding:15px;border:1px solid #c00;border-radius:5px;'>";
    echo "<b>Fatal Error:</b> " . htmlspecialchars($e->getMessage()) . "<br>";
    echo "<b>File:</b> " . htmlspecialchars($e->getFile()) . " line " . $e->getLine() . "<br><br>";
    echo "<pre>" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    echo "</div>";
}
