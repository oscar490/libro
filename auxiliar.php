<?php

const CABECERAS = [
    "titulo"=>"Título",
    "autor"=>"Autor",
    "resumen"=>"Resumen",
    "num_pags"=>"Número de páginas",
    "tema"=>"Tema"
];

function conectar()
{
    try {
        return new PDO('pgsql:host=localhost;dbname=libro', 'libro', 'libro');
    } catch (PDOException $e) {
        ?>
        <h4>Ha ocurrido un error en la Base de Datos</h4>
        <?php
    }
}

function buscarLibro(PDO $pdo, string $titulo)
{
    $sent = $pdo->prepare("SELECT l.id, titulo, autor, num_pags,
                                resumen, tema_id, nombre
                             AS tema
                           FROM libros l
                           JOIN temas t ON l.tema_id = t.id
                          WHERE lower(titulo) LIKE lower(:titulo) ");

    $sent->execute([":titulo"=>"%$titulo%"]);

    return $sent->fetchAll();
}

function mostrarTabla(array $datos)
{

    ?>
    <table border="1">
        <thead>
    <?php foreach (CABECERAS as $k => $v): ?>
            <th><?= $v ?></th>
    <?php endforeach; ?>
        </thead>
        <tbody>

    <?php foreach ($datos as $fila): ?>
            <tr>
                <td><?= $fila['titulo'] ?></td>
                <td><?= $fila['autor'] ?></td>
                <td><?= $fila['resumen'] ?></td>
                <td><?= $fila['num_pags'] ?></td>
                <td><?= $fila['tema'] ?></td>
            </tr>
    <?php endforeach ?>
        </tbody>
    </table>
    <?php

}
