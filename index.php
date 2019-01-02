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
	<div class="row">
		<span> Selecione as Tabelas </span>
		<select name="" id="tableSelector">
			<option value="1">Usuario</option>
			<option value="2">Função</option>
			<option value="3" selected>Todos</option>
		</select>

		<div id="tableUsuario">
			<h1>Usuario </h1>
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
					include 'banco.php';
					$pdo = Banco::connect();
					$sql = 'SELECT * FROM usuario ORDER BY id DESC';
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
		</div>
		<div id="tableFuncao">
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
						echo '</tr>';
					}
					Banco::disconnect();
					?>
				</tbody>
			</table>
		</div>
		
	</div>
</body>
</html>