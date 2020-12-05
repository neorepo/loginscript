<?php

require_once 'constantes.php';
/**
 * Logs out current user, if any.  Based on Example #1 at
 * http://us.php.net/manual/en/function.session-destroy.php.
 */
function logout() {
    // unset any session variables
    $_SESSION = array();
    // expire cookie
    if (!empty($_COOKIE[session_name()])) {
        setcookie(session_name(), "", time() - 42000);
    }
    // destroy session
    session_destroy();
}

/**
 * Redirects user to destination, which can be
 * a URL or a relative path on the local host.
 * 
 * Because this function outputs an HTTP header, it
 * must be called before caller outputs any HTML.
 */
function redirect($destination) {
    // handle URL
    if (preg_match("/^https?:\/\//", $destination)) {
        header("Location: " . $destination);
    }
    // handle absolute path
    else if (preg_match("/^\//", $destination)) {
        $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
        $host = $_SERVER["HTTP_HOST"];
        header("Location: $protocol://$host$destination");
    }
    // handle relative path
    else {
        // adapted from http://www.php.net/header
        $protocol = (isset($_SERVER["HTTPS"])) ? "https" : "http";
        $host = $_SERVER["HTTP_HOST"];
        $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
        header("Location: $protocol://$host$path/$destination");
    }
    // exit immediately since we're redirecting anyway
    exit;
}

// Funciones útiles
function testInput($value) {
    return htmlspecialchars(stripslashes(trim($value)));
}
// Solo letras y espacios en blanco
function soloLetras($value) {
    return preg_match('/^[a-zA-ZáéíóúÁÉÍÓÚÑñÜü ]+$/', $value);
}
// Solo números son permitidos
function soloNumeros($value) {
    return preg_match('/^[\d]+$/', $value);
}
function emailValido($email) {
    // FILTER_SANITIZE_EMAIL => Elimina todos los caracteres menos letras, dígitos y !#$%&'*+-=?^_`{|}~@.[].
    $email = filter_var($email, FILTER_SANITIZE_EMAIL);
    // https://owasp.org/www-community/OWASP_Validation_Regex_Repository
    $regexEmail= '/^[a-zA-Z0-9_+&*-]+(?:\.[a-zA-Z0-9_+&*-]+)*@(?:[a-zA-Z0-9-]+\.)+[a-zA-Z]{2,7}$/';
    return preg_match($regexEmail, $email);
    // O
    // return filter_var($email, FILTER_VALIDATE_EMAIL);
    // FILTER_VALIDATE_EMAIL => En general, se valildan direcciones de correo electrónico con la sintaxis de RFC 822, 
    // con la excepción de no admitir el plegamiento de comentarios y espacios en blanco. 
}
function longitudMaxima($value, $longitudMaxima) {
    return mb_strlen($value) <= $longitudMaxima;
}
function longitudMinima($value, $longitudMinima) {
    return mb_strlen($value) >= $longitudMinima;
}
function longitudValidaEmail($email, $longitudMinima, $longitudMaxima) {
    $aux = explode('@', $email)[0];
    $strlen = mb_strlen($aux);
    return ($strlen >= $minlength && $strlen <= $maxlength);
}
// Hash contraseña
function hashPassword($password) {
    return password_hash($password . PEPPER, PASSWORD_BCRYPT, ['cost' => 12]);
}
// Verificar el hash de la contraseña
function verifyPassword($password, $passwordHash) {
    return (password_verify($password . PEPPER, $passwordHash) == $passwordHash);
}
function contraseniaSegura($password) {
    $uppercase = preg_match('/[A-Z]/', $password);
    $lowercase = preg_match('/[a-z]/', $password);
    $number = preg_match('/[0-9]/', $password);
    
    $patterns = ['/[A-Z]/', '/[a-z]/', '/[0-9]/'];
    $replacements = ['', '', ''];
    $password = preg_replace($patterns, $replacements, $password);
    
    $specialChars = preg_match('/^[' . preg_quote(PASSWORD_SYMBOLS) . ']+$/', $password);
    if (!$uppercase || !$lowercase || !$number || !$specialChars) {
        return false;
    }
    return true;
}
function existeEmailUsuario($email) {
    if (getUsuarioPorEmail($email)) {
        return true;
    }
    return false;
}
/**
 * Devuelve true si el string contiene un caracter numérico positivo
 * false en caso contrario
 */
function enteroPositivo($n) {
    if( get_int($n) ) {
        $n = (int) $n;
        if($n > 0) {
            return true;
        }
    }
    return false;
}

/**
 * Válida un string con caracteres numéricos enteros
 */
function get_int($n) {
    if ($n === null) {
        return 0;
    }
    // Si es un caracter numérico entero
    return preg_match('/^[+-]?\d+$/', $n);
}

/**
 * Válida un string con caracteres numéricos decimales
 */
function get_float($n) {
    if ($n === null) {
        return 0;
    }
    // Si es un caracter numérico decimal
    return preg_match('/^[+-]?\d*(?:\.\d*)?$/', $n);
}
function isEmpty($value) {
    return !mb_strlen($value);
}

// Lógica de persistecia
function getUsuarioPorEmail($email) {
    $sql = 'SELECT * FROM usuario WHERE email = ? LIMIT 1;';
    $rows = Db::query($sql, $email);
    if (count($rows) == 1) {
        return $rows[0];
    }
    return null;
}
function insertarUsuario($usuario) {
    $ahora = date('Y-m-d H:i:s');
    $sql = 'INSERT INTO usuario (apellido, nombre, email, password, created, last_modified) VALUES(?, ?, ?, ?, ?, ?);';
    return Db::query($sql, $usuario['apellido'], $usuario['nombre'], $usuario['email'], $usuario['password'], $ahora, $ahora);
}