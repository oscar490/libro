<?php

define('FPP', 5);

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

const DEFECTO = [
    "titulo"=>"",
    "autor"=>"",
    "resumen"=>"",
    "num_pags"=>"",
    "tema_id"=>"",
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
    <div align='center'>
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
    </div>
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

function comprobarTitulo(string $titulo, array &$error)
{
    if ($titulo === '') {
        $error[] = 'El título es obligatorio';
    }

    if (mb_strlen($titulo) > 255) {
        $error[] = 'El título es demasiado largo';
    }
}

function comprobarAutor(string $autor, array &$error)
{
    if ($autor === '') {
        $error[] = 'El nombre del autor es obligatorio';
    }

    if (mb_strlen($autor) > 255) {
        $error[] = 'El nombre del autor es demasiado largo';
    }
}

function comprobarNumPaginas($numPaginas, array &$error)
{
    if ($numPaginas === '') {
        return;
    }

    $filtro = filter_var($numPaginas, FILTER_VALIDATE_INT, [
        'options' => [
            'min_range' => 0,
            'max_range' => 9999,
        ]
    ]);

    if ($filtro === false) {
        $error[] = 'El número de páginas no es válido';
    }

}



function modificar(PDO $pdo, $id, array $datos, array &$error)
{

    $sets = [];
    $exec = [];
    foreach ($datos as $k=>$v):
        $sets[] = "$k = :$k";
        $exec[":$k"] = $v === '' ? null : $v;
    endforeach;
    $exec[":id"] = $id;

    $campos = implode(', ', $sets);
    $sent = $pdo->prepare("UPDATE libros
                            SET $campos
                           WHERE id = :id");
    $sent->execute($exec);

}

function insertar(PDO $pdo, array $datos)
{
    $colum = [];
    $exec = [];
    foreach ($datos as $k => $v):
        if ($v === '') {
            continue;
        }
        $colum[] = $k;
        $exec[] = $v;
    endforeach;
    $values = array_fill(0, count($colum), '?');

    $columnas = implode(', ', $colum);
    $valores = implode(', ', $values);

    $sent = $pdo->prepare("INSERT INTO libros ($columnas)
                            VALUES ($valores)");

    $sent->execute($exec);


}

function buscarUsuario(PDO $pdo, $usuario, array &$error)
{
    $sent = $pdo->prepare("SELECT *
                             FROM usuarios
                            WHERE usuario = :usuario");

    $sent->execute([":usuario"=>$usuario]);

    if ($sent->rowCount() === 0) {
        $error[] = 'El usuario no existe';
    }

    return $sent->fetch();
}

function comprobarUsuario(string $usuario, array &$error)
{
    if ($usuario === '') {
        $error[] = 'El nombre de usuario es obligatorio';
    }
}

function comprobarPassword($password1, $password2, &$error )
{
    if ($password1 === '') {
        $error[] = 'El password es obligatorio';
        return;
    }

    if (!password_verify($password1, $password2)) {
        $error[] = 'El password no coincide';
    }
}

function comprobarLogueado()
{
    if (isset($_SESSION['login'])) {
        return true;
    }
    $_SESSION['mensaje'] = 'Usuario no identificado';
    header('Location: index.php');
    return false;
}
