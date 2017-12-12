<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Borrar un Libro</title>
    </head>
    <body>
        <?php
        require 'auxiliar.php';
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $pdo = conectar();
        $error = [];
        try {
            $fila = consultarLibro($pdo, $id, $error);
            comprobarErrores($error);
        } catch (Exception $e) {
            mostrarErrores($error);
        }
        $pdo = conectar();


        ?>

        <h3>¿Seguro que deseas borrar el libro <?= $fila['titulo'] ?>?</h3>
        <form  method="post">
            <input type="submit" value="Si">
            <a href='index.php' >No</a>
        </form>
    </body>
</html>
