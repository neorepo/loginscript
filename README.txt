Repositorio de expresiones regulares de validación de OWASP
https://owasp.org/www-community/OWASP_Validation_Regex_Repository

OWASP Cheat Sheet Series
https://cheatsheetseries.owasp.org/

Avast, generador de contraseñas aleatorias
https://www.avast.com/es-ar/random-password-generator ejemplo (%2JG^+WOu_Nr#)

Comprueba la fortaleza de tu contraseña
https://password.kaspersky.com/es/

CONSIDERACIONES, EXPRESIÓN REGULAR PARA EL E-MAIL
Una dirección de correo electrónico válida es una cadena que coincide con la producción de correo electrónico del siguiente ABNF (Augmented BNF for Syntax Specifications: ABNF), 
cuyo conjunto de caracteres es Unicode. Este ABNF implementa las extensiones descritas en RFC 1123. [ABNF] [RFC5322] [RFC1034] [RFC1123]
https://html.spec.whatwg.org/multipage/input.html#valid-e-mail-address
La siguiente expresión regular compatible con JavaScript y Perl es una implementación de la definición anterior.
regexEmail_RFC5322 = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/

Regular Expressions for Email Addresses
Las direcciones de correo electrónico que no cumplan con estas reglas de producción modernas pueden, no obstante, 
ser válidas bajo las otras reglas de producción modernas (por ejemplo, [RFC5322]) o heredadas (por ejemplo, [RFC0821] y [RFC0822]).
https://tools.ietf.org/id/draft-seantek-mail-regexen-03.html#rfc.section.3

Tutorial acerca del restablecimiento de contraseña
https://cheatsheetseries.owasp.org/cheatsheets/Forgot_Password_Cheat_Sheet.html

https://www.w3.org/Bugs/Public/show_bug.cgi?id=15489
Here’s a simple test case for how current browsers implement this: http://jsbin.com/acomah

Longitudes máximas de contraseña (64 caracteres)
https://cheatsheetseries.owasp.org/cheatsheets/Password_Storage_Cheat_Sheet.html#maximum-password-lengths

REGEX
\w Coincide con cualquier letra, dígito o subrayado. Equivalente a [a-zA-Z0-9_]. [^a-zA-Z0-9_] Cualquier carácter excepto a-zA-Z0-9_
\W Coincide con cualquier cosa que no sea una letra, un dígito o un guión bajo.

REQUERIMIENTOS DE CONTRASEÑA DEL SITIO NETACAD
La nueva contraseña debe incluir:
Una mayúscula
Una minúscula
Un número
Una longitud de 8 a 60 caracteres
Sin caracteres especiales, excepto estos: @ . - _ ~ ! # $ % ^ & *
La contraseña no puede contener la totalidad o parte de su dirección de correo electrónico
La contraseña nueva no puede ser la misma que la actual.

Contraseñas de usuario
smithjohn@yahoo.com => J!c#E$%*S3i-^3_l~@. | J@.c-~!E_#$3%^*3 => T@.-o_~!P#$%1^&*2
usuario2 => f~fvnjs7ePLC.^g

https://www.w3.org/WAI/WCAG21/Techniques/server-side-script/SVR1
En PHP, los desarrolladores pueden enviar un encabezado HTTP sin procesar con el método header().
El siguiente código envía un código de estado 301 y una nueva ubicación. Si el estado no se establece 
explícitamente, la respuesta de redireccionamiento envía un código de estado HTTP 302.
<?php
header("HTTP/1.1 301 Moved Permanently);
header("Location: http://www.example.com/newUserLogin.php");
?>