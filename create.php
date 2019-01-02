<?php 
include 'banco.php';

if ( !empty($_POST)) {

	$idError = null;
	$nomeError = null;
	$idadeError = null;
	$funcaoError = null;

        // Dados do Header
	$nome = $_POST['nome'];
	$idade = $_POST['idade'];
	$funcao = $_POST['funcao'];

        // Validando
	$validUsuario = true;
	$validFuncao = true;
	if (empty($nome)) {
		$nomeError = 'Por Favor digite um nome';
		$validUsuario = false;
	}
	if (empty($idade)) {
		$idadeError = 'Por favor digite uma idade';
		$validUsuario = false;
	}
	if (empty($funcao)) {
		$funcaoError = 'Por favor digite o nome da função';
		$validFuncao = true;
	}

        // Criando Usuario
	if ($validUsuario) {
		$pdo = Banco::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO usuario (nome,idade) values(?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($nome,$idade));
		Banco::disconnect();
		header("Location: read.php");
	}
	else if ($validFuncao) {
		$pdo = Banco::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO funcao (nome) values(?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($funcao));
		Banco::disconnect();
		header("Location: read.php");
	}

}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<script src="function.js"></script>
</head>
<body>
	<header>
		<ul>
			<li><a href="./index.php">Home</a></li>
			<li><a href="./create.php">Create</a></li>
			<li><a href="./read.php">Read</a></li>
			<li><a href="./update.php">Update</a></li>
			<li><a href="./delete.php">Delete</a></li>
		</ul>
	</header>
	<div>
		<h1>Create</h1>
		<span> Selecione as Tabelas </span>
		<select name="" id="tableSelector">
			<option value="1">Usuario</option>
			<option value="2">Função</option>
		</select>

		<section id="tableUsuario">
			
			<h1>Usuario</h1>

			<form action="create.php" method="post">
				<div class="row">
					<span>Nome</span> 
					<?php 
					if (!empty($nomeError)): 
						echo "<span>empty".($nomeError)."</span>";
					endif;
					?>
					<input name="nome" type="text" placeholder="Nome de usuario" value="<?php echo !empty($nome)?$nome:'';?>">
				</div>
				<div class="row">
					<span>Idade</span> 
					<?php 
					if (!empty($idadeError)): 
						echo "<span>empty".($idadeError)."</span>";
					endif;
					?>
					<input type="text" name="idade" type="text" placeholder="Idade do usuário" value="<?php echo !empty($idade)?$idade:'';?>">
				</div>	
				<button type="submit" >Adicionar Usuario</button>			
			</form>

			<table>
				<thead>
					<tr>
						<th>Id</th>
						<th>Nome</th>
						<th>Idade</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$pdo = Banco::connect();
					$sql = 'SELECT * FROM usuario ORDER BY id DESC LIMIT 3';
					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['id'] . '</td>';
						echo '<td>'. $row['nome'] . '</td>';
						echo '<td>'. $row['idade'] . '</td>';
						echo '</tr>';
					}
					
					?>
				</tbody>
			</table>	
		</section>

		<section id="tableFuncao" hidden="true">
			
			<h1>Função</h1>


			
			<form action="create.php" method="post">
				<div class="row">
					<span>Função</span>
					<?php 
					if (!empty($funcaoError)): 
						echo "<span>empty".($funcaoError)."</span>";
					endif;
					?>
					<input type="text" name="funcao" type="text" placeholder="Nova função" value="<?php echo !empty($funcao)?$funcao:'';?>">
				</div>
				<button type="submit" >Adicionar Função</button>
			</form>

			<table>
				<thead>
					<tr>
						<th>Id</th>
						<th>nome</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = 'SELECT * FROM funcao ORDER BY id DESC LIMIT 3';
					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['id'] . '</td>';
						echo '<td>'. $row['nome'] . '</td>';
						echo '</tr>';
					}
					Banco::disconnect();
					?>
				</tbody>
			</table>
		</section>

	</div>
</body>
</html>