<?php

require_once __DIR__ . '/../config/config.php';

$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

header('Content-Type: application/json; charset=utf-8');

if (in_array($origin, $allowedOrigins)) {
    header("Access-Control-Allow-Origin: $origin");
    header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');
}

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$uri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?? '/';

match ($uri) {
    '/api/users', '/api/users/' => require __DIR__ . '/../src/apis.php',
    default      => notFound(),
};

function notFound(): void
{
    http_response_code(404);
    echo json_encode(['error' => 'Endpoint not found']);
    exit;
}