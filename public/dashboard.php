<?php

require_once '../includes/funciones.php';

$flashMessage = null;
if (isset($_SESSION['_flash'])) {
    $flashMessage = $_SESSION['_flash'];
    unset($_SESSION['_flash']);
}

// Vista, archivo con formulario de registro.
$template = '../templates/dashboard.html';
require_once '../templates/base.html';