<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Lista de Libros</title>
    </head>
    <body>
        <?php
        require 'auxiliar.php';

        $valor = trim(filter_input(INPUT_GET, 'valor'));
        $columna = trim(filter_input(INPUT_GET, 'columna'));
        $pdo = conectar();
        var_dump($valor);
        var_dump($columna);

        if ($columna === '') {
            $columna = 'titulo';
        }
        $fila = buscarLibro($pdo, $columna, $valor);

        ?>
        <form method="get">
            <select class="" name="columna">
                <?php foreach (CABECERAS as $k => $v): ?>
                    <option value="<?= $k ?>"
                        <?= seleccion($k, $columna) ?>>
                            <?= $v ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="valor" value="<?= $valor ?>">
            <input type="submit" value="Buscar">
        </form>

        <?php

        mostrarTabla($fila);

        ?>
    </body>
</html>
