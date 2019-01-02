<?php 
include 'banco.php';

if ( !empty($_POST)) {

	$idError = null;
	$nomeError = null;
	$idadeError = null;
	$acessoError = null;
	$funcaoError = null;

        // Dados do Header
	!empty($_POST['nome']) ? $nome = $_POST['nome'] : $nome = null ;
	!empty($_POST['idade']) ? $idade = $_POST['idade'] : $idade = null;
	!empty($_POST['acesso']) ? $acesso = $_POST['acesso'] : $acesso = null;
	!empty($_POST['funcao']) ? $funcao = $_POST['funcao'] : $funcao = null;

        // Validando
	$validUsuario = true;
	$validFuncao = true;
	if (!isset($nome)) {
		$nomeError = 'Por Favor digite um nome';
		$validUsuario = false;
	}
	if (!isset($idade)) {
		$idadeError = 'Por favor digite uma idade';
		$validUsuario = false;
	}
	if (!isset($acesso)) {
		$funcaoError = 'Por favor digite um nível de acesso';
		$validUsuario = false;
	}
	if (!isset($funcao)) {
		$funcaoError = 'Por favor digite o nome da função';
		$validFuncao = false;
	}

        // Criando Usuario
	if ($validUsuario) {
		$pdo = Banco::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO usuario (nome,idade, acesso) values(?, ?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($nome,$idade, $acesso));
		Banco::disconnect();
		header("Location: read.php");
	}
	else if ($validFuncao) {
		$pdo = Banco::connect();
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$sql = "INSERT INTO funcao (nome, acesso) values(?, ?)";
		$q = $pdo->prepare($sql);
		$q->execute(array($funcao, $acesso));
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
					
					<input name="nome" type="text" placeholder="Nome de usuario" value="<?php echo !empty($nome)?$nome:'';?>">

					<?php 
					if (!empty($nomeError)): 
						echo "<span>".($nomeError)."</span>";
					endif;
					?>
				</div>
				<div class="row">
					<span>Idade</span> 
					
					<input type="text" name="idade" type="text" placeholder="Idade do usuário" value="<?php echo !empty($idade)?$idade:'';?>">

					<?php 
					if (!empty($idadeError)): 
						echo "<span>".($idadeError)."</span>";
					endif;
					?>
				</div>	
				<div class="row">
					<span>Nível de Acesso</span> 
					
					<input type="text" name="acesso" type="text" placeholder="Nível de Acesso do usuário" value="<?php echo !empty($acesso)?$acesso:'';?>">

					<?php 
					if (!empty($acessoError)): 
						echo "<span>".($acessoError)."</span>";
					endif;
					?>
				</div>	
				<button type="submit" >Adicionar Usuario</button>			
			</form>

			<table>
				<thead>
					<tr>
						<th>Id</th>
						<th>Nome</th>
						<th>Idade</th>
						<th>Acesso</th>
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
						echo '<td>'. $row['acesso'] . '</td>';
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
					
					<input type="text" name="funcao" type="text" placeholder="Nova função" value="<?php echo !empty($funcao)?$funcao:'';?>">

					<?php 
					if (!empty($funcaoError)):
						echo "<span>".($funcaoError)."</span>";
					endif;
					?>
				</div>
				<div class="row">
					<span>Nível de Acesso</span>
					
					<input type="text" name="acesso" type="text" placeholder="Nova função" value="<?php echo !empty($acesso)?$acesso:'';?>">

					<?php 
					if (!empty($funcaoError)):
						echo "<span>".($acessoError)."</span>";
					endif;
					?>
				</div>
				<button type="submit" >Adicionar Função</button>
			</form>

			<table>
				<thead>
					<tr>
						<th>Id</th>
						<th>nome</th>
						<th>Nível de Acesso</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = 'SELECT * FROM funcao ORDER BY id DESC LIMIT 3';
					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['id'] . '</td>';
						echo '<td>'. $row['nome'] . '</td>';
						echo '<td>'. $row['acesso'] . '</td>';
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