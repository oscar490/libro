<?php session_start(); ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Modificación de un Libro</title>
    </head>
    <body>
        <?php
        require 'auxiliar.php';

        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $pdo = conectar();
        $error = [];
        try {
            comprobarParametro($id, $error);
            $fila = consultarLibro($pdo, $id, $error);
            comprobarErrores($error);

            if (!empty($_POST)) {

                $libro = filter_input(INPUT_POST, 'libro', FILTER_DEFAULT,
                    FILTER_REQUIRE_ARRAY);

                try {
                    comprobarTitulo($libro['titulo'], $error);
                    comprobarAutor($libro['autor'], $error);
                    comprobarNumPaginas($libro['num_pags'], $error);
                    comprobarErrores($error);
                    modificar($pdo, $id, $libro, $error);
                    $_SESSION['mensaje'] = 'Se ha modificado correctamente';
                    header('Location: index.php');
                } catch (Exception $e) {
                    mostrarErrores($error);
                }
            }
        ?>

        <form class=""  method="post">
            <div class="">
                <label for="titulo">Título * :</label>
                <input type="text" size='30' name="libro[titulo]"
                    value="<?= $fila['titulo']?>">
            </div>
            <div class="">
                <label for="autor">Autor * :</label>
                <input type="text" name="libro[autor]"
                    value="<?= $fila['autor']?>">
            </div>
            <div class="">
                <label for="numPag">Número de páginas :</label>
                <input type="text" name="libro[num_pags]"
                    value="<?= $fila['num_pags']?>">
            </div>
            <div class="">
                <label for="resumen">Resumen :</label>
                <textarea name="libro[resumen]" rows="8" cols="80"
                    ><?= $fila['resumen'] ?></textarea>
            </div>
            <div class="">
                <label for="tema">Tema: </label>
                <select name="libro[tema_id]">
                    <?php listaDesplegable($fila['tema_id']) ?>
                </select>
            </div>
            <input type='submit' value='Modificar'  />
            <a href='index.php' >Cancelar</a>
        </form>
        <?php
        } catch (Exception $e) {
            mostrarErrores($error);
            ?><a href='index.php'>Volver</a><?php
        }
        ?>
    </body>
</html>
