<?php
define('SECRET_KEY', 'meditrust_key_2026');

function encryptNik($nik) {
    if (empty($nik)) {
        return '';
    }

    return openssl_encrypt($nik, 'AES-128-ECB', SECRET_KEY);
}

function decryptNik($encryptedNik) {
    if (empty($encryptedNik)) {
        return '';
    }

    return openssl_decrypt($encryptedNik, 'AES-128-ECB', SECRET_KEY);
}
?>