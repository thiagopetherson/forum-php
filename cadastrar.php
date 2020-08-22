<?php 
	ini_set('display_errors', '1');
	require("models/config.php");
	require("models/usuario.class.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Cadastrar usuario</title>
		<meta charset="utf-8">
		<link href="css/cadastrar.css" rel="stylesheets">
	</head>
	<body>
		<form action="" method="POST">
			<label for="nome">Nome</label>
			<input type="text" name="username"><br>
			<label for="password">Senha</label>
			<input type="password" name="password"><br>
			<input type="submit" value="registrar">
		</form>
	</body>
</html>

<?php

	if(isset($_POST['username']) && !empty($_POST['username'])){
		$username = addslashes($_POST['username']);
		$password = addslashes($_POST['password']);
		$user = new Usuario($pdo);
		$user->setUsername($username);
		$user->setPassword($password);
		if($user->addUser()){
			echo "usuário cadastrado com successo";
		}
		else{
			echo "Falha ao cadastrar usuário";
			print_r($user->showErros());
		}

	}

?>