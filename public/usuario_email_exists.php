<?php
// Respuesta solicitud XMLHttpRequest por el email de usuario en el formulario de registro.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/Config.php';
    require_once '../src/Db.php';
    $email = $_POST['email'];
    $sql = "SELECT id_usuario FROM usuario WHERE email = ? LIMIT 1;";
    $rows = Db::query($sql, $email);
    if (!$rows) { // if (!$rows) = count($rows) === 0,
        echo "ok";
    } else {
        echo "error";
    }
}
else {
    redirect('index.php');
}
