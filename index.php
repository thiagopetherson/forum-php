<!DOCTYPE html>
<html>
<head>
    <title>Bem vindo ao For 1</title>
    <meta charset="utf8">
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div id="main_container">
    <header>
        <h1>Faça login ou cadastre-se</h1>
    </header>
    <main>
        <section>
            <form id="login"  method="POST">
                <label for="username">Usuário</label>
                <input type="text" name="username" required maxlength="30"><br>
                <label for="password">Senha</label>
                <input type="password" name="password"/><br>
                <input type="submit" value="login">
            </form>            
            <a href="reset_password.php">Esqueci minha senha</a>
            <a href="cadastrar.php">Criar nova conta</a>
        </section>
    </main>
    <foorter>
        <p>2020 - For1 - Forum livre</p>
    </foorter>
    </div>
</body>
</html>

<?php

    require "models/config.php";
    require "models/usuario.class.php";

    if(!empty($_POST['username'])){
        $username = addslashes($_POST['username']);
        $password = addslashes($_POST['password']);
        $usuario = new Usuario($pdo);
        $usuario->setUsername($username);
        $usuario->setPassword($password);
        if($usuario->checkVars())
            if($usuario->loginUser() == 0)
                echo "usuário não cadastrado";
            else
                echo "Bem vindo ao for1";
        else
            $usuario->showErros();

    }

?>