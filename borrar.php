<?php session_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Borrar un Libro</title>
    </head>
    <body>
        <?php
        require 'auxiliar.php';
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT) ?? false;
        $pdo = conectar();
        $error = [];
        try {
            comprobarParametro($id, $error);
            $fila = consultarLibro($pdo, $id, $error);
            comprobarErrores($error);

            if (!empty($_POST)) {

                $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
                
                borrar($pdo, $id);
                $_SESSION['mensaje'] = 'Libro borrado con éxito';
                header('Location: index.php');
            }
            ?>
            <h3>¿Seguro que deseas borrar el libro <?= $fila['titulo'] ?>?</h3>
            <form  method="post">
                <input type="submit" value="Si">
                <input type="hidden" name='id' value="<?= $fila['id'] ?>">
                <a href='index.php' >No</a>
            </form>
            <?php


        } catch (Exception $e) {
            mostrarErrores($error);
            ?>
            <a href='index.php'>Volver</a>
            <?php
        }
        $pdo = conectar();


        ?>


    </body>
</html>
