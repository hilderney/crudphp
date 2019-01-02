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
		<div id="tableJoin">
			<h1>Usuários + Funções </h1>
			<table>
				<thead>
					<tr>
						<th>Id</th>
						<th>Nome</th>
						<th>Idade</th>
						<th>Cargo</th>
					</tr>
				</thead>
				<tbody>
					<?php
					include 'banco.php';
					$pdo = Banco::connect();
					$sql = 'SELECT U.id, U.nome, U.idade, F.nome as funcao FROM usuario AS U INNER JOIN funcao AS F ON U.acesso = F.acesso ORDER BY F.acesso DESC';
					foreach ($pdo->query($sql) as $row) {
						echo '<tr>';
						echo '<td>'. $row['id'] . '</td>';
						echo '<td>'. $row['nome'] . '</td>';
						echo '<td>'. $row['idade'] . '</td>';
						echo '<td>'. $row['funcao'] . '</td>';
						
						echo '</tr>';
					}

					?>
				</tbody>
			</table>
		</div>
		
	</div>
</body>
</html>