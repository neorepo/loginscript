<?php

$mascota = [
    'id_especie' => 1,
    'id_raza' => 5
];

$especies = [
    [
        'id_especie' => 1,
        'nombre' => 'Perro'
    ],
    [
        'id_especie' => 2,
        'nombre' => 'Gato'
    ]
];

$razas = [
    [
        'id_raza' => 1,
        'nombre' => 'Pastor alemán',
        'id_especie' => 1
    ],
    [
        'id_raza' => 2,
        'nombre' => 'Bulldog',
        'id_especie' => 1
    ],
    [
        'id_raza' => 3,
        'nombre' => 'Poodle',
        'id_especie' => 1
    ],
    [
        'id_raza' => 4,
        'nombre' => 'Labrador retriever',
        'id_especie' => 1
    ],
    [
        'id_raza' => 5,
        'nombre' => 'Lebrel afgano',
        'id_especie' => 1
    ],
    [
        'id_raza' => 6,
        'nombre' => 'Siamés',
        'id_especie' => 2
    ],
    [
        'id_raza' => 7,
        'nombre' => 'Común',
        'id_especie' => 2
    ],
    [
        'id_raza' => 8,
        'nombre' => 'Persa',
        'id_especie' => 2
    ]
];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    foreach ($mascota as $key => $value) {
        if (array_key_exists($key, $_POST)) {
            $mascota[$key] = htmlspecialchars(stripslashes(trim($_POST[$key])));
        }
    }
    echo '<pre>';
    print_r($mascota);
    echo '</pre>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba de filtrado en elemento select</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
        integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
</head>
<body class="container p-5">

<form action="" method="POST">
    <div class="form-group">
        <label for="id-especie">Especie:</label>
        <select name="id_especie" id="id-especie" class="custom-select">
            <?php foreach ($especies as $key => $especie): ?>
            <option value="<?= $especie['id_especie']; ?>" <?= ($especie['id_especie'] == $mascota['id_especie']) ? 'selected' : ''; ?>><?= $especie['nombre']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="id-raza">Raza:</label>
        <select name="id_raza" id="id-raza" class="custom-select">
            <option value="">- Seleccionar -</option>
            <?php foreach ($razas as $key => $raza): ?>
            <option value="<?= $raza['id_raza']; ?>" data-id-especie="<?= $raza['id_especie']; ?>" <?= ($raza['id_raza'] == $mascota['id_raza']) ? 'selected' : ''; ?>><?= $raza['nombre']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-dark">Enviar</button>
</form>


<script>
    const selectEspecie = document.querySelector('select#id-especie');
    const selectRaza = document.querySelector('select#id-raza');

    document.addEventListener('DOMContentLoaded', (e) => {
        
        // Si en la carga del documento existen la variables
        if (selectEspecie) {
            let option = selectEspecie.options[selectEspecie.selectedIndex];
            mostrarOcultar(option);
        }

        // Manejador del evento onchange
        initOnchangeSelect();
    });

    // document.body.onload = function (e) {};

    // En el cambio de option
    function initOnchangeSelect() {
        if (selectEspecie) {
            // https://www.w3.org/WAI/WCAG21/Techniques/client-side-script/SCR24
            selectEspecie.onchange = function (e) { mostrarOcultar(this, e); }
        }
    }

    function mostrarOcultar(obj, objEvent) {
        // Omitimos la siguiente comprobación, por que en la línea 119 necesitamos invocar a la función.
        // if (objEvent && objEvent.type == 'change') {}
        if (!selectRaza) return;
        let idEspecie = obj.value;
        selectRaza.querySelectorAll('option').forEach(option => option.style.display = 'none');
        Array.from(selectRaza.getElementsByTagName('option'))
            .filter(option => option.dataset.idEspecie === idEspecie).forEach(option => option.style.display = 'block');
        selectRaza.value = '';
    }
</script>
</body>
</html>