<?php
// Get the path after domain
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove base folder
$base = '/Refund-Portal/portal';
$slug = trim(str_replace($base, '', $path), '/');

// Routing
switch ($slug) {
    case '':
    case 'home':
        require __DIR__ . '/parts/header.php';
        require __DIR__ . '/parts/navbar.php';
        require __DIR__ . '/refund.php';
        require __DIR__ . '/parts/footer.php';
        break;

    case 'table':
        require __DIR__ . '/table.php';
        break;

    case 'paymentplan':
        require __DIR__ . '/paymentplan.php';
        break;

    case 'agreement':
        require __DIR__ . '/agreement.php';
        break;

    case 'agreementsave':
        require __DIR__ . '/function.php';
        break;

    case 'success':
        require __DIR__ . '/success.php';
        break;

    default:
        require __DIR__ . '/parts/header.php';
        echo "<h2 class='text-center mt-5 text-danger'>404 - Page Not Found</h2>";
        require __DIR__ . '/parts/footer.php';
        break;
}
