<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Lista de Libros</title>
    </head>
    <body>
        <?php
        require 'auxiliar.php';

        $titulo = trim(filter_input(INPUT_GET, 'titulo'));
        $pdo = conectar();
        var_dump($titulo);
        $fila = buscarLibro($pdo, $titulo);

        ?>
        <form method="get">
            <select class="" name="columna">
                <?php foreach (CABECERAS as $k => $v): ?>
                    <option value="<?= $k ?>"><?= $v ?></option>
                <?php endforeach; ?>
            </select>
            <input type="text" name="titulo" value="">
            <input type="submit" value="Buscar">
        </form>

        <?php

        mostrarTabla($fila);

        ?>
    </body>
</html>
