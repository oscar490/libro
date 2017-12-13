<?php session_start() ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Login</title>
        <style>
            div {
                margin-top: 100px;
            }
        </style>
    </head>
    <body>
        <?php
        require 'auxiliar.php';

        $usuario =  trim(filter_input(INPUT_POST, 'usuario'));
        $password = trim(filter_input(INPUT_POST, 'password'));
        $pdo = conectar();
        $error = [];

        if (!empty($_POST)):

            try {
                comprobarUsuario($usuario, $error);
                $fila = buscarUsuario($pdo, $usuario, $error);
                comprobarPassword($password, $fila['password'], $error);
                comprobarErrores($error);
                $_SESSION['login'] = [
                    'id' => $fila['id'],
                    'usuario' => $fila['usuario'],
                ];
                header('Location: index.php');
            } catch (Exception $e) {
                mostrarErrores($error);
            }
        endif;

        ?>
        <form class=""  method="post">
            <div  align='center'>
                <label for="">Usuario * : </label>
                <input type="text" name='usuario'
                    value="<?= $usuario ?>"/><br /><br />
                <label for="">Password * : </label>
                <input type="password" name='password'
                    value="<?= $password ?>"/><br /><br />
                <input type="submit" value="Login" />
                <a href='index.php'>Cancelar</a>
            </div>
        </form>
    </body>
</html>
