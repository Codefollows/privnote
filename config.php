<?php
// Database configuration
$host = 'localhost';
$db   = 'database';
$user = 'username';
$pass = 'password';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

define('ENCRYPTION_KEY', 'YOURKEY');


function encrypt($data) {
    $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
    $encryptedData = openssl_encrypt($data, 'aes-256-cbc', ENCRYPTION_KEY, 0, $iv);
    return base64_encode($encryptedData . '::' . $iv);
}

function decrypt($data) {
    list($encryptedData, $iv) = array_pad(explode('::', base64_decode($data), 2), 2, null);
    return openssl_decrypt($encryptedData, 'aes-256-cbc', ENCRYPTION_KEY, 0, $iv);
}




?>
