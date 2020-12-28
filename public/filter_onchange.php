<?php

$mascota = [
    'id_especie' => 1,
    'id_raza' => 5
];

$especies = [['id_especie' => 1,'nombre' => 'Perro'],['id_especie' => 2,'nombre' => 'Gato']];

$razas = [
    ['id_raza' => 1,'nombre' => 'Pastor alemán','id_especie' => 1],['id_raza' => 2,'nombre' => 'Bulldog','id_especie' => 1],
    ['id_raza' => 3,'nombre' => 'Poodle','id_especie' => 1],['id_raza' => 4,'nombre' => 'Labrador retriever','id_especie' => 1],
    ['id_raza' => 5,'nombre' => 'Lebrel afgano','id_especie' => 1],['id_raza' => 6,'nombre' => 'Siamés','id_especie' => 2],
    ['id_raza' => 7,'nombre' => 'Común','id_especie' => 2],['id_raza' => 8,'nombre' => 'Persa','id_especie' => 2]
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

<h1>Ejemplo del evento onchange</h1>

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
        <select name="id_raza" id="id-raza" class="custom-select" required>
            <option value="">- Seleccionar -</option>
            <?php foreach ($razas as $key => $raza): ?>
            <!-- https://www.youtube.com/watch?v=x5trGVMKTdY&list=PLhQjrBD2T380xvFSUmToMMzERZ3qB5Ueu&index=7 min: 53:00 -->
            <option value="<?= $raza['id_raza']; ?>" data-id-especie="<?= $raza['id_especie']; ?>" <?= ($raza['id_raza'] == $mascota['id_raza']) ? 'selected' : ''; ?>><?= $raza['nombre']; ?></option>
            <?php endforeach; ?>
        </select>
    </div>

    <button type="submit" class="btn btn-dark">Enviar</button>
</form>


<script>
    // Dynamic select
    // https://www.w3.org/WAI/WCAG21/Techniques/client-side-script/SCR19.html
    
    const selectEspecie = document.querySelector('select#id-especie');
    const selectRaza = document.querySelector('select#id-raza');

    var obj = setInterval(bind, 500);
    // https://www.youtube.com/watch?v=x5trGVMKTdY&list=PLhQjrBD2T380xvFSUmToMMzERZ3qB5Ueu&index=7
    // Más eficiente y se reduce la cant. de caracteres en el script min 20:50
    const h1El = document.querySelector("h1");
    function bind() {
        if (h1El) {
            if (h1El.style.visibility === "visible") {
                h1El.style.visibility = "hidden";
            } else {
                h1El.style.visibility = "visible";
            }
        }
    }

    document.addEventListener('DOMContentLoaded', (e) => {
        
        // En el evento DOMContentLoaded
        initContentLoaded(e);

        // En el evento onchange
        initOnchangeSelect();
    });

    // document.body.onload = function (e) {};
    function initContentLoaded(e) {
        // https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_option_index
        // https://www.w3schools.com/jsref/tryit.asp?filename=tryjsref_select_selectedindex
        if (selectEspecie) {
            const opt = selectEspecie.options[selectEspecie.selectedIndex];
            mostrarOcultar(opt, e);
        }
    }

    // En el cambio de opción
    function initOnchangeSelect() {
        if (selectEspecie) {
            // https://www.w3.org/WAI/WCAG21/Techniques/client-side-script/SCR24
            selectEspecie.onchange = function (e) { mostrarOcultar(this, e); }
        }
    }

    // Filtrar opciones y mostrar
    function mostrarOcultar(obj, objEvent) {
        if (!selectRaza) return;
        if (objEvent && objEvent.type == 'change' || objEvent.type == 'DOMContentLoaded') {
            const idEspecie = obj.value;
            // Array.prototype.filter.call(selectRaza.querySelectorAll('option'), filterFn);
            selectRaza.querySelectorAll('option').forEach(opt => opt.style.display = 'none');
            Array.from(selectRaza.getElementsByTagName('option'))
                .filter(opt => opt.dataset.idEspecie === idEspecie)
                .forEach(opt => opt.style.display = 'block');
            // selectRaza.value = '';
            selectRaza.selectedIndex = '0';
        }
    }
</script>
    <!--<ul id="list">
        <li class="item">SAM</li>
        <li style="color: #FFC011;">NEO</li>
        <li data-item="JUL">JUL</li>
        <li id="name">VIC</li>
        <li title="SIL">SIL</li>
        <li style="color: #00A2E6;">GEO</li>
    </ul>-->

    <!-- https://html.spec.whatwg.org/multipage/form-elements.html#the-select-element -->
    <form>
        <label for="empleado">Empleado:</label>
        <select name="empleado" id="empleado" required>
            <!-- Cuando no hay una opción predeterminada, se puede usar un marcador de posición en su lugar: -->
            <option value="">- Seleccione un empleado -</option>
            <option value="GOMEZ">GOMEZ</option>
            <option value="ESCOBAR">ESCOBAR</option>
            <option value="RUFINO">RUFINO</option>
            <option value="RODRIGUEZ">RODRIGUEZ</option>
            <option value="BARRERA">BARRERA</option>
            <option value="OROSCO" name="apellido">OROSCO</option>
            <option value="YPANAQUE">YPANAQUE</option>
        </select>

        <button type="submit">Enviar</button>
    </form>

    <script>

        /*const list = document.querySelector("#list");
        const items = list.querySelectorAll("li");
        Array.prototype.filter.call(items, item => item.hasAttribute("style")).forEach(item => {item.style.cssText += "font-size: 64px;";});*/

        const eList = document.querySelector("#empleado");

        // Devuelve "select-multiple" si el elemento tiene un atributo múltiple y "select-one" en caso contrario.
        console.log(eList.type);

        // Devuelve un HTMLOptionsCollection de la lista de opciones.
        console.log(eList.options);

        // Devuelve el número de elementos de la lista de opciones.
        // Cuando se establece en un número menor, trunca el número de elementos de opción en la selección. Ejm: select.length = -1;
        // Cuando se establece en un número mayor, agrega nuevos elementos de opción en blanco a la selección. Ejm: select.length = 10;
        console.log("Longitud: " + eList.length);

        // Devuelve el elemento con índice de índice de la lista de opciones. Los elementos se ordenan en árbol.
        const lastElement = eList.item(eList.length - 1); // O eList[eList.length - 1]
        console.log(lastElement);

        // Devuelve el primer elemento con el atributo ID o NAME de la lista de opciones.
        // Devuelve nulo si no se pudo encontrar ningún elemento con ese ID.
        const element = eList.namedItem("apellido");
        console.log(element);

        // Devuelve un HTMLCollection de la lista de opciones seleccionadas.
        console.log(eList.selectedOptions);

        // Devuelve el índice del primer elemento seleccionado, si lo hay, o -1 si no hay ningún elemento seleccionado.
        // Se puede configurar para cambiar la selección.
        console.log("Índice seleccionado: " + eList.selectedIndex); // en el evento onchange devolverá el índice que ha sido seleccionado.

        // Devuelve el valor del primer elemento seleccionado, si lo hay, o la cadena vacía si no hay ningún elemento seleccionado.
        // Se puede configurar para cambiar la selección.
        console.log("Valor del primer elemento selecionado: " + eList.value);

    </script>
</body>
</html>