<?php
// Respuesta solicitud XMLHttpRequest por el email de usuario en el formulario de registro.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    require_once '../config/Config.php';
    require_once '../src/Db.php';
    $email = $_POST['email'];
    $sql = "SELECT id_usuario FROM usuario WHERE email = ? LIMIT 1;";
    $rows = Db::query($sql, $email);
    if (count($rows) == 1) {
        echo "error";
    } else {
        echo "ok";
    }
}
else {
    redirect('index.php');
}
