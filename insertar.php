<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Insertar un Libro</title>
    </head>
    <body>
        <?php
        require 'auxiliar.php';

        $libro = filter_input(INPUT_POST, 'libro', FILTER_DEFAULT,
            FILTER_REQUIRE_ARRAY) ?? [];
        $error = [];
        $pdo = conectar();

        $libro = array_merge(DEFECTO, $libro);
        if (!empty($_POST)):

            try {
                comprobarTitulo($libro['titulo'], $error);
                comprobarAutor($libro['autor'], $error);
                comprobarNumPaginas($libro['num_pags'], $error);
                comprobarErrores($error);
            } catch (Exception $e) {
                mostrarErrores($error);
            }
        endif;


        ?>
        <form class=""  method="post">
            <div class="">
                <label for="titulo">Título * :</label>
                <input type="text" size='30' name="libro[titulo]"
                    value="<?= $libro['titulo']?>">
            </div>
            <div class="">
                <label for="autor">Autor * :</label>
                <input type="text" name="libro[autor]"
                    value="<?= $libro['autor']?>">
            </div>
            <div class="">
                <label for="numPag">Número de páginas :</label>
                <input type="text" name="libro[num_pags]"
                    value="<?= $libro['num_pags']?>">
            </div>
            <div class="">
                <label for="resumen">Resumen :</label>
                <textarea name="libro[resumen]" rows="8" cols="80"
                    ><?= $libro['resumen'] ?></textarea>
            </div>
            <div class="">
                <label for="tema">Tema: </label>
                <select name="libro[tema_id]">
                    <?php listaDesplegable($libro['tema_id']) ?>
                </select>
            </div>
            <input type='submit' value='Insertar'  />
            <a href='index.php' >Cancelar</a>
        </form>
    </body>
</html>
