<?php session_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Lista de Libros</title>
        <style>
            table {
                margin-top: 50px;

            }
        </style>
    </head>
    <body>


        <?php
        require 'auxiliar.php';

        $valor = trim(filter_input(INPUT_GET, 'valor'));
        $columna = trim(filter_input(INPUT_GET, 'columna'));
        $pdo = conectar();
        $pag = filter_input(INPUT_GET, 'fila', FILTER_VALIDATE_INT, [
            "options" => [
                "default" = 1,
                "min_range" = 1,
                "max_range" = FPP,
            ]
        ]);

        if (!in_array($columna, array_keys(CABECERAS))) {
            $columna = 'titulo';
        }
        $fila = buscarLibro($pdo, $columna, $valor);

        if (isset($_SESSION['mensaje'])) {
            ?>
            <h4><?= $_SESSION['mensaje']?></h4>
            <?php
            unset($_SESSION['mensaje']);
        }

        if (isset($_SESSION['login'])) {
            ?>
            <h4>Usuario: <?= $_SESSION['login']['usuario'] ?></h4>
            <h4><a href='logout.php'>Logout</a></h4>
            <?php
        } else {
            ?>
            <h4><a href='login.php'>Login</a></h4>
            <?php
        }

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

        <a href='insertar.php'>Insertar libro</a>
    </body>
</html>
