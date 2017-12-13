<?php

const CABECERAS = [
    "titulo"=>"Título",
    "autor"=>"Autor",
    "resumen"=>"Resumen",
    "num_pags"=>"Número de páginas",
    "nombre"=>"Tema",
];

const COLUMNAS = [
    "Titulo",
    "Autor",
    "Resumen",
    "Número de páginas",
    "Tema",
    "Operaciones"
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

function consultarLibro(PDO $pdo, int $id, array &$error)
{
    $sent = $pdo->prepare("SELECT *
                             FROM  libros
                            WHERE  id = :id");

    $sent->execute([":id"=>$id]);

    if ($sent->rowCount() === 0) {
        $error[] = 'El libro no existe';
    }

    return $sent->fetch();
}

function mostrarTabla(array $datos)
{

    ?>
    <table border="1">
        <thead>
    <?php foreach (COLUMNAS as $k => $v): ?>
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
                <td colspan="2">
                    <a href="borrar.php?id=<?= $fila['id'] ?>">Borrar</a>
                    <a href="modificar.php?id=<?= $fila['id'] ?>">Modificar</a>
                </td>
            </tr>
    <?php endforeach ?>
        </tbody>
    </table>
    <?php

}

function mostrarErrores(array $error)
{
    foreach ($error as $v):
        ?>
        <h4>Error: <?= $v ?></h4>
        <?php
    endforeach;
}

function comprobarErrores(array $error)
{
    if (!empty($error)) {
        throw new Exception;
    }
}

function comprobarParametro($param, array &$error)
{
    if ($param === false) {
        $error[] = 'Parámetro incorrecto';
    }
}

function borrar(PDO $pdo, $id)
{
    $sent = $pdo->prepare("DELETE FROM libros
                            WHERE id = :id");

    $sent->execute([":id"=>$id]);
}

function listaDesplegable($id)
{
    $pdo = conectar();
    $sent = $pdo->query("SELECT * FROM temas");

    foreach ($sent as $fila):
        ?>
        <option value="<?= $fila['id']?>" <?= seleccion($id, $fila['id']) ?>>
            <?= $fila['nombre'] ?>
        </option>
        <?php
    endforeach;
}
