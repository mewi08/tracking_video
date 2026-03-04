<?php
session_start();

require_once __DIR__ . '/vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$LTI_KEY    = $_ENV['LTI_KEY'];
$LTI_SECRET = $_ENV['LTI_SECRET'];

// ==============================
// 1. Verificar método POST
// ==============================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die('Unauthorized access');
}

// ==============================
// 2. Verificar consumer key
// ==============================
if (!isset($_POST['oauth_consumer_key']) || $_POST['oauth_consumer_key'] !== $LTI_KEY) {
    die('Invalid key');
}

// ==============================
// 3. Verificar OAuth signature
// ==============================

if (!isset($_POST['oauth_signature'])) {
    die('Missing OAuth signature');
}

$receivedSignature = $_POST['oauth_signature'];

// Copiar parámetros y eliminar firma
$params = $_POST;
unset($params['oauth_signature']);

// Ordenar alfabéticamente
ksort($params);

// Codificación OAuth correcta
$encodedParams = [];
foreach ($params as $key => $value) {
    $encodedParams[] = rawurlencode($key) . '=' . rawurlencode($value);
}

$paramString = implode('&', $encodedParams);

// ==============================
// Construir URL EXACTA usada en la firma
// ==============================

// Detectar esquema
$scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? "https" : "http";

// IMPORTANTE: usar PHP_SELF (sin query string)
$launchUrl = $scheme . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

// Construir base string
$baseString = 'POST' . '&' .
    rawurlencode($launchUrl) . '&' .
    rawurlencode($paramString);

// Clave de firma
$signingKey = rawurlencode($LTI_SECRET) . '&';

// Generar firma esperada
$expectedSignature = base64_encode(
    hash_hmac('sha1', $baseString, $signingKey, true)
);

// Comparación segura
if (!hash_equals($expectedSignature, $receivedSignature)) {
    die('Invalid OAuth signature');
}

// ==============================
// 4. Guardar datos en sesión
// ==============================

$_SESSION['user_id']   = $_POST['user_id']                         ?? null;
$_SESSION['course_id'] = $_POST['context_id']                      ?? null;
$_SESSION['name_full'] = $_POST['lis_person_name_full']             ?? null;
$_SESSION['email']     = $_POST['lis_person_contact_email_primary'] ?? null;
$_SESSION['roles']     = $_POST['roles']                            ?? '';

// ==============================
// 5. Redirigir según rol
// ==============================

$roles = $_SESSION['roles'];

if (str_contains($roles, 'Administrator')) {
    header("Location: /tracking/views/admin.php");
} else {
    header("Location: /tracking/views/student.php");
}
exit;