<?php 
	include 'banco.php';

	$passedId = null;
	$passedNome = null;
	$passedIdade = null;
	$passedAcesso = null;
	$passedTable = null;

	if ( !empty($_GET)) {
		$usuarioToEditError = null;
		$funcaoToEditError = null;

		if (!empty($_GET['usuariotoedit'])) 
			$usuarioToEdit = $_GET['usuariotoedit'];
		if (!empty($_GET['funcaotoedit'])) 
        	$funcaoToEdit = $_GET['funcaotoedit'];

        $isUsuario = false;
        $isFuncao = false;

        if (!empty($usuarioToEdit)) {

        	$pdo = Banco::connect();
        	$sql = 'SELECT * FROM usuario where id = '.$usuarioToEdit;
        	foreach ($pdo->query($sql) as $row) {
        		if (!empty($row['id'])) {
        			$passedId = $row['id'];
        			$passedNome = $row['nome'];
        			$passedIdade = $row['idade'];
        			$passedAcesso = $row['acesso'];
        			$isUsuario = true;
        			$passedTable = "usuario";
        		}
        		else {
        			$usuarioToEditError = "Usuário inexistente.";
        		}
        	}
        }

        if (!empty($funcaoToEdit)) {
        	$pdo = Banco::connect();
        	$sql = 'SELECT * FROM funcao where id = '.$funcaoToEdit;
        	foreach ($pdo->query($sql) as $row) {
        		if (!empty($row['id'])) {
        			$passedId = $row['id'];
        			$passedNome = $row['nome'];
        			$passedAcesso = $row['acesso'];
        			$isFuncao = true;
        			$passedTable = "funcao";
        		}
        		else {
        			$usuarioToEditError = "Função  inexistente.";
        		}
        	}
		}
	}

	if ( !empty($_POST)) {
        
       	$idError = null;
        $nomeError = null;
        $idadeError = null;
        $acessoError = null;
        $funcaoError = null;
         
        // Dados do Header
        $id = $_POST['id'];
        $nome = $_POST['nome'];
        $idade = $_POST['idade'];
        $acesso = $_POST['acesso'];
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
        if (empty($acesso)) {
            $acessoError = 'Por favor digite uma acesso';
            $validUsuario = false;
        }
        if (empty($funcao)) {
        	$funcaoError = 'Por favor digite o nome da função';
        	$validFuncao = true;
        }
         
        // Alterando Usuario ou Funcao
        if ($validUsuario) {
            $pdo = Banco::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE usuario SET nome = ?, idade = ?, acesso = ? WHERE id = ? ";
            $q = $pdo->prepare($sql);
            $q->execute(array($nome, $idade, $acesso, $id));
            Banco::disconnect();
            header("Location: read.php");
        }
        else if ($validFuncao) {
        	$pdo = Banco::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "UPDATE funcao SET nome = ?, acesso = ? WHERE id = ? ";
            $q = $pdo->prepare($sql);
            $q->execute(array($funcao, $acesso, $id));
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
		<h1> Update
			<?php 
				$passedTable=="usuario" ? print(" de usuário: ". $passedNome ) : "" ;
				$passedTable=="funcao" ? print(" de Função: ". $passedNome ) : "" ;
 		 	?> </h1>

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
							<th>Acesso</th>
							<th>Ação</th>
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
							echo '<td>'. $row['acesso']. '</td>';
							echo '<td> 
								<button> <a href="./update.php?usuariotoedit='.$row['id'].'" >editar</a> </button>
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
							<th>Acesso</th>
							<th>Ação</th>
						</tr>
					</thead>
					<tbody>
						<?php
						$sql = 'SELECT * FROM funcao ORDER BY id DESC';
						foreach ($pdo->query($sql) as $row) {
							echo '<tr>';
							echo '<td>'. $row['id'] . '</td>';
							echo '<td>'. $row['nome'] . '</td>';
							echo '<td>'. $row['acesso']. '</td>';
							echo '<td> 
								<button> <a href="./update.php?funcaotoedit='.$row['id'].'" >editar</a> </button>
								</td>';
							echo '</tr>';
						}
						Banco::disconnect();
						?>
					</tbody>
				</table>
			</div>
		<?php endif; ?>
		
		<?php if ($passedTable=="usuario" ) : ?>
			
			<form action="update.php" method="post">
				<div class="row">
					<span>Nome</span> 
					<?php 
						if (!empty($nomeError)): 
						echo "<span>empty".($nomeError)."</span>";
						endif;
					?>
					<input type="hidden" name="id" value="<?php echo $passedId ?>" > 
					<input name="nome" type="text" placeholder="Nome" value="<?php echo !empty($passedNome) ? $passedNome : '' ; ?>">
				</div>
				<div class="row">
					<span>Idade</span> 
					<?php 
						if (!empty($idadeError)): 
						echo "<span>empty".($idadeError)."</span>";
						endif;
					?>
					<input type="text" name="idade" type="text" placeholder="Idade" value="<?php echo !empty($passedIdade) ? $passedIdade : '' ; ?>">
				</div>	
				<div class="row">
					<span>Nível de Acesso</span> 
					<?php 
						if (!empty($acessoError)): 
						echo "<span>empty".($acessoError)."</span>";
						endif;
					?>
					<input type="text" name="acesso" type="text" placeholder="Nível de Acesso" value="<?php echo !empty($passedAcesso) ? $passedAcesso : '' ; ?>">
				</div>
				<button type="submit" >Atualizar Usuario</button>			
			</form>

		<?php endif; ?>

		<?php if ($passedTable=="funcao") : ?>

			<form action="update.php" method="post">
				<div class="row">
					<span>Função</span>
					<?php 
						if (!empty($funcaoError)): 
						echo "<span>empty".($funcaoError)."</span>";
						endif;
					?>
					<input type="hidden" name="id" value="<?php echo $passedId ?>" > 
					<input type="text" name="funcao" type="text" placeholder="Função" value="<?php echo !empty($passedNome) ? $passedNome : '' ; ?>">
				</div>
				<div class="row">
					<span>Nível de Acesso</span> 
					<?php 
						if (!empty($acessoError)): 
						echo "<span>empty".($acessoError)."</span>";
						endif;
					?>
					<input type="text" name="acesso" type="text" placeholder="Nível de Acesso" value="<?php echo !empty($passedAcesso) ? $passedAcesso : '' ; ?>">
				</div>
				<button type="submit" >Atualizar Função</button>
			</form>

		<?php endif; ?>
	</div>
</body>
</html>