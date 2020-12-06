<?php

session_start();

define('LONGITUD_MAXIMA', 40);
define('LONGITUD_MINIMA', 3);
define('LONGITUD_MINIMA_EMAIL', 6);
define('LONGITUD_MAXIMA_EMAIL', 30);
define('MAX_PASSWORD_LENGTH', 60);
define('MIN_PASSWORD_LENGTH', 8);
define('PASSWORD_SYMBOLS', '@.-_~!#$%^&*');
// https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html#peppering
define('PEPPER', 'r8UN#uHVX5x~&4+ZaG&y'); // 20 caracteres

// Feedback messages
$messages = [
    'requerido' => 'Completa este campo.',
    'soloLetras' => 'Solo se permiten letras (a-z) y espacios en blanco.',
    'emailInvalido' => 'Introduce una dirección de correo electrónico válida PHP.',
    'clavesDiferentes' => 'Las contraseñas no coinciden; inténtalo de nuevo.',
    'longitudMaximaInvalida' => 'Reduce la longitud a ' . LONGITUD_MAXIMA . ' caracteres o menos.',
    'longitudMinimaInvalida' => 'Aumenta la longitud a ' . LONGITUD_MINIMA . ' caracteres como mínimo.'
];