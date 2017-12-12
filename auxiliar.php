<?php

const CABECERAS = [
    "titulo"=>"Título",
    "autor"=>"Autor",
    "resumen"=>"Resumen",
    "num_pags"=>"Número de páginas",
    "nombre"=>"Tema"
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

function seleccion($x, $y)
{
    return $x == $y ? 'selected' : '';
}

function buscarLibro(PDO $pdo, string $columna, string $valor)
{
    switch ($columna) {
        case 'num_pags':
            $clausulas = "WHERE $columna = :columna";
            $exec = [":columna"=>$valor];
            break;

        case 'nombre':
            $clausulas = "WHERE $columna = :columna";
            $exec = [":columna"=>$valor];
            break;

        case 'resumen':
        default:

            $clausulas = "WHERE lower($columna) LIKE lower(:columna)";
            $exec = [":columna"=>"%$valor%"];
    }

    $sent = $pdo->prepare("SELECT l.id, titulo, autor, num_pags,
                                resumen, tema_id, nombre
                             AS tema
                           FROM libros l
                           JOIN temas t ON l.tema_id = t.id
                           $clausulas");

    $sent->execute($exec);

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
