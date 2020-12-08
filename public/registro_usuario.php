<?php
require_once '../config/Config.php';
require_once '../src/Db.php';

require_once '../includes/funciones.php';
require_once '../src/Token.php';

// Array con valores por defecto
$usuario = [
    'apellido' => null,
    'nombre' => null,
    'email' => null,
    'password' => null,
    'confirm_password' => null
];

// Error de registro de usuario
$registroExitoso = true;

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

    // Validación del apellido
    if (!$usuario['apellido']) {
        $errors['apellido'] = $messages['requerido'];
    } elseif (!soloLetras($usuario['apellido'])) {
        $errors['apellido'] = $messages['soloLetras'];
    } elseif (!longitudMaxima($usuario['apellido'], LONGITUD_MAXIMA)) {
        $errors['apellido'] = $messages['longitudMaximaInvalida'];
    } elseif (!longitudMinima($usuario['apellido'], LONGITUD_MINIMA)) {
        $errors['apellido'] = $messages['longitudMinimaInvalida'];
    }

    // Validación del nombre
    if (!$usuario['nombre']) {
        $errors['nombre'] = $messages['requerido'];
    } elseif (!soloLetras($usuario['nombre'])) {
        $errors['nombre'] = $messages['soloLetras'];
    } elseif (!longitudMaxima($usuario['nombre'], LONGITUD_MAXIMA)) {
        $errors['nombre'] = $messages['longitudMaximaInvalida'];
    } elseif (!longitudMinima($usuario['nombre'], LONGITUD_MINIMA)) {
        $errors['nombre'] = $messages['longitudMinimaInvalida'];
    }

    // Validación del e-mail
    if (!$usuario['email']) {
        $errors['email'] = $messages['requerido'];
    } elseif (!emailValido($usuario['email'])) {
        $errors['email'] = $messages['emailInvalido'];
    } elseif (existeEmailUsuario($usuario['email'])) {
        $errors['email'] = 'Ese e-mail ya está registrado. Prueba con otro PHP.';
    }

    // Validación de las contraseñas
    if (!$usuario['password']) {
        $errors['password'] = 'Introduzca una contraseña.';
    } elseif (!longitudMinima($usuario['password'], MIN_PASSWORD_LENGTH)) {
        $errors['password'] = 'Usa ' . MIN_PASSWORD_LENGTH . ' caracteres como mínimo para la contraseña.';
    } elseif (!longitudMaxima($usuario['password'], MAX_PASSWORD_LENGTH)) {
        $errors['password'] = 'Usa ' . MAX_PASSWORD_LENGTH . ' caracteres como máximo para la contraseña.';
    }
    elseif (!contraseniaSegura($usuario['password'])) {
        $errors['password'] = 'La contraseña debe incluir <b>al menos una letra mayúscula, una letra minúscula, 
        un número y solo caracteres como: ' . PASSWORD_SYMBOLS . '</b>';
        // $errors['password'] = 'Elige una contraseña más segura. Prueba con una combinación de letras, números y símbolos.';
    } elseif (!$usuario['confirm_password']) {
        $errors['confirm_password'] = 'Confirme su contraseña.';
        // Comparación segura a nivel binario sensible a mayúsculas y minúsculas.
    } elseif ( strcmp( $usuario['password'], $usuario['confirm_password'] ) !== 0 ) {
        $errors['confirm_password'] = $messages['clavesDiferentes'];
    }
    // La contraseña no puede empezar ni terminar con un espacio en blanco.

    // Si no existen errores
    if (empty($errors)) {

        // Hasheamos la contraseña
        $usuario['password'] = hashPassword($usuario['password']);

        // Insertamos en la base de datos
        if (insertarUsuario($usuario)) {
            $_SESSION['_flash'] = 'El registro se realizó correctamente. Ahora puedes ingresar en la aplicación.';
            redirect('login_usuario.php');
        }
        // Si devuelve false
        else {
            $registroExitoso = false;
        }
    }
}

$flashMessage = null;
if (isset($_SESSION['_flash'])) {
    $flashMessage = $_SESSION['_flash'];
    unset($_SESSION['_flash']);
}

// Vista, archivo con formulario de registro.
$template = '../templates/usuario/registro_usuario.html';
require_once '../templates/base.html';