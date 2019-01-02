<?php 

include 'banco.php';

$passedId = null;
$passedNome = null;
$passedIdade = null;
$passedTable = null;

if ( !empty($_GET)) {
	$usuarioToDeleteError = null;
	$funcaoToDeleteError = null;

	if (!empty($_GET['usuariotodelete'])) 
		$usuarioToDelete = $_GET['usuariotodelete'];
	if (!empty($_GET['funcaotodelete'])) 
		$funcaoToDelete = $_GET['funcaotodelete'];

	$isUsuario = false;
	$isFuncao = false;

	if (!empty($usuarioToDelete)) {

		$pdo = Banco::connect();
		$sql = 'SELECT * FROM usuario where id = '.$usuarioToDelete;
		foreach ($pdo->query($sql) as $row) {
			if (!empty($row['id'])) {
				$passedId = $row['id'];
				$passedNome = $row['nome'];
				$passedIdade = $row['idade'];
				$isUsuario = true;
				$passedTable = "usuario";
			}
			else {
				$usuarioToDeleteError = "Não foi possível encontrar esse usuário.";
			}
		}
	}

	if (!empty($funcaoToDelete)) {
		$pdo = Banco::connect();
		$sql = 'SELECT * FROM funcao where id = '.$funcaoToDelete;
		foreach ($pdo->query($sql) as $row) {
			if (!empty($row['id'])) {
				$passedId = $row['id'];
				$passedNome = $row['nome'];
				$isFuncao = true;
				$passedTable = "funcao";
			}
			else {
				$usuarioToDeleteError = "Não foi possível excluir essa função.";
			}
		}
	}

	if (!empty($_GET['usuariotofinallydelete'])) {
		$idToDelete = $_GET['usuariotofinallydelete'];
		$pdo = Banco::connect();
		$sql = 'SELECT * FROM usuario where id = '.$idToDelete;
		foreach ($pdo->query($sql) as $row) {
			if (!empty($row['id'])) {
				$passedId = $row['id'];
				$count = $pdo->exec('DELETE FROM usuario where id = '.$passedId);
				header("Location: read.php");
			}
			else {
				$usuarioToDeleteError = "Não foi possível excluir essa função.";
			}
		}
	}

	if (!empty($_GET['funcaotofinallydelete'])) {
		$idToDelete = $_GET['funcaotofinallydelete'];
		$pdo = Banco::connect();
		$sql = 'SELECT * FROM funcao where id = '.$idToDelete;
		foreach ($pdo->query($sql) as $row) {
			if (!empty($row['id'])) {
				$passedId = $row['id'];
				$count = $pdo->exec('DELETE FROM funcao where id = '.$passedId);
				header("Location: read.php");
			}
			else {
				$usuarioToDeleteError = "Não foi possível excluir essa função.";
			}
		}
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
		<h1>Delete</h1>

		<?php if (empty($passedTable)) : ?>
			<span> Selecione as Tabelas </span>
			<select name="" id="tableSelector">
				<option value="1">Usuario</option>
				<option value="2">Função</option>
			</select>

			<div id="tableUsuario">
				<h1>Usuario</h1>
				<table>
					<thead>
						<tr>
							<th>Id</th>
							<th>Nome</th>
							<th>Idade</th>
							<th>Função</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$pdo = Banco::connect();
						$sql = 'SELECT * FROM usuario ORDER BY id DESC';
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';
							echo '<td>'. $row['id'] . '</td>';
							echo '<td>'. $row['nome'] . '</td>';
							echo '<td>'. $row['idade'] . '</td>';
							echo '<td> 
							<button> <a href="./delete.php?usuariotodelete='.$row['id'].'" >apagar</a> </button>
							</td>';
							echo '</tr>';
						}
						
						?>
					</tbody>
				</table>
			</div>
			<div id="tableFuncao" hidden="true">
				<h1>Função</h1>
				<table>
					<thead>
						<tr>
							<th>Id</th>
							<th>nome</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = 'SELECT * FROM funcao ORDER BY id DESC';
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';
							echo '<td>'. $row['id'] . '</td>';
							echo '<td>'. $row['nome'] . '</td>';
							echo '<td> 
							<button> <a href="./delete.php?funcaotodelete='.$row['id'].'" >apagar</a> </button>
							</td>';
							echo '</tr>';
						}
						Banco::disconnect();
						?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>

		<?php if ($passedTable=="usuario") : ?>
			<div class="row">
				<h2>
					<div class="row">
						Deseja Realmente excluir o Usuário: 
						<em> <?php echo $passedNome ?> </em>
					</div>
					<div class="row">
						De idade:
						<em> <?php echo $passedIdade ?> </em>
					</div>
				</h2>
				<form action="delete.php">
					<button> <a href="<?php 
					print('./delete.php?usuariotofinallydelete='.$passedId.''); ?>" >Sim quero Deletar</a> </button>
				</form>
			</div>
		<?php endif; ?>

		<?php if ($passedTable=="funcao") : ?>
			<div class="row">
				<h2>
					<div class="row">
						Deseja Realmente excluir a Função: 
						<em> <?php echo $passedNome ?> </em>
					</div>
				</h2>
				<form action="delete.php">
					<button> <a href="<?php 
					print('./delete.php?funcaotofinallydelete='.$passedId.''); ?>" >Sim quero Deletar</a> </button>
				</form>
			</div>
		<?php endif; ?>
	</div>
</body>
</html>