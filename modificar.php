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
        $fila = consultarLibro($pdo, $id, $error);
        
        ?>

        <form class="" action="index.html" method="post">
            <div class="">
                <label for="titulo">Título *:</label>
                <input type="text" name="libro[titulo]"
                    value="<?= $fila['titulo']?>">
            </div>
            <div class="">
                <label for="autor">Autor :</label>
                <input type="text" name="libro[autor]"
                    value="<?= $fila['autor']?>">
            </div>
            <div class="">
                <label for="numPag">Número de páginas :</label>
                <input type="text" name="libro[num_paginas]"
                    value="<?= $fila['num_pags']?>">
            </div>
            <div class="">
                <label for="resumen">Resumen :</label>
                <textarea name="libro[resumen]" rows="8" cols="80"
                    ><?= $fila['resumen'] ?></textarea>
            </div>
            <div class="">
                <label for="tema">Tema: </label>
                <select>
                    <?php listaDesplegable($fila['tema_id']) ?>
                </select>
            </div>
        </form>
    </body>
</html>
