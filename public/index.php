<?php
// Simple front controller / router
declare(strict_types=1);

// Base path to project root
define('BASE_PATH', dirname(__DIR__));

session_start();

// Basic autoloader for controllers and models
spl_autoload_register(function ($class) {
    $paths = [
        BASE_PATH . '/app/controllers/' . $class . '.php',
        BASE_PATH . '/app/models/' . $class . '.php',
    ];
    foreach ($paths as $p) {
        if (file_exists($p)) {
            require_once $p;
            return true;
        }
    }
    return false;
});

// Authentication guard: redirect to login if not authenticated
$isPublicRoute = isset($_GET['route']) && (
    str_starts_with($_GET['route'], 'auth/login') ||
    str_starts_with($_GET['route'], 'auth/do_login')
);

if (empty($_SESSION['user']) && !$isPublicRoute) {
    header('Location: index.php?route=auth/login');
    exit;
}

// routing
$route = $_GET['route'] ?? 'auth/login'; // Default to login if not authenticated
[$controllerSegment, $action] = array_pad(explode('/', $route), 2, 'index');

// Simple plural -> singular controller name heuristic: remove trailing s
if (str_ends_with($controllerSegment, 's')) {
    $controllerName = substr($controllerSegment, 0, -1);
} else {
    $controllerName = $controllerSegment;
}

$controllerClass = ucfirst($controllerName) . 'Controller';
$controllerFile = BASE_PATH . '/app/controllers/' . $controllerClass . '.php';

try {
    if (!file_exists($controllerFile)) {
        throw new RuntimeException('Controller not found: ' . $controllerClass);
    }
    require_once $controllerFile;
    if (!class_exists($controllerClass)) {
        throw new RuntimeException('Controller class missing: ' . $controllerClass);
    }

    $controller = new $controllerClass();
    if (!method_exists($controller, $action)) {
        throw new RuntimeException('Action not found: ' . $action);
    }

    // Call action. Some actions expect GET param id or POST data.
    $controller->{$action}();

} catch (Throwable $e) {
    http_response_code(500);
    echo '<h1>Error</h1>';
    echo '<p>' . htmlspecialchars($e->getMessage()) . '</p>';
}
