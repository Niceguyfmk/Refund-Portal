<?php
// Get the path after domain
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove parent folders (/Refund-Portal/portal)
$base = '/Refund-Portal/portal';
$slug = trim(str_replace($base, '', $path), '/');

// Routing
if ($slug === '' || $slug === 'home') {
    require_once __DIR__ . '/parts/header.php';
    require_once __DIR__ . '/parts/navbar.php';
    require_once __DIR__ . '/refund.php';
    require_once __DIR__ . '/parts/footer.php';

} elseif ($slug === 'table') {
   // require_once __DIR__ . '/parts/header.php';
   // require_once __DIR__ . '/parts/navbar.php';
    require_once __DIR__ . '/table.php';
   // require_once __DIR__ . '/parts/footer.php';

} elseif ($slug === 'verify') {
    require_once __DIR__ . '/function.php';

} else {
    require_once __DIR__ . '/parts/header.php';
    echo "<h2>404 - Page Not Found</h2>";
    require_once __DIR__ . '/parts/footer.php';
}
