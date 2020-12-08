<?php
require_once '../config/Config.php';
require_once '../src/Db.php';

require_once '../includes/funciones.php';
require_once '../src/Token.php';

// Array con valores por defecto
$usuario = [
    'email' => null,
    'password' => null
];

// Error de inicio de sesión
$accesoExitoso = true;

// Array para errores de formulario
$errors = [];

// Método de solicitud POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    if (array_key_exists('token', $_POST)) {
        if (!Token::validate($_POST['token'])) {
            // Si el token CSRF que enviaron no coincide con el que enviamos.
            redirect('logout.php');
        }
    } else {
        // No existe la key token
        redirect('logout.php');
    }

    // Asignación de valores si existen las variables definidas en el formulario.
    foreach ($usuario as $key => $value) {
        if (array_key_exists($key, $_POST)) {
            $usuario[$key] = testInput($_POST[$key]);
        }
    }

    // var_dump($usuario);
    /*if (!$usuario['email']) {
        $errors['email'] = $messages['requerido'];
    }

    if (!$usuario['password']) {
        $errors['password'] = $messages['requerido'];
    }*/

    // Si no existen errores
    // if (empty($errors)) {
        // Insertamos en la base de datos
        if (validarCredenciales($usuario['email'], $usuario['password'])) {
            $_SESSION['_flash'] = 'Te has logueado correctamente.';
            redirect('dashboard.php');
        }
        // Si devuelve false
        else {
            $accesoExitoso = false;
        }
    // }
}

$flashMessage = null;
if (isset($_SESSION['_flash'])) {
    $flashMessage = $_SESSION['_flash'];
    unset($_SESSION['_flash']);
}

// Vista, archivo con formulario de registro.
$template = '../templates/usuario/login_usuario.html';
require_once '../templates/base.html';

// Lógica de persistencia
function validarCredenciales($email, $password) {
    $sql = 'SELECT * FROM usuario WHERE email = ? LIMIT 1;';
    $rows = Db::query($sql, $email);
    if (count($rows) == 1) {
        $usuario = $rows[0];
        if (verifyPassword( $password, $usuario['password'])) {
            // unset any session variables
            $_SESSION = [];
            $_SESSION['id_usuario'] = $usuario['id_usuario'];
            $_SESSION['nombre_usuario'] = $usuario['nombre'] . ' ' . $usuario['apellido'];
            return true;
        }
    }
    return false;
}