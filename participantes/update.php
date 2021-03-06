<?php
	include('../inc/dll.php');
	if(!empty($_POST)) {
		//Errores de validacion
		$participant_id_error = null;
		$participant_type_code_error = null;
		$participant_name_error = null;
		$participant_lastname_error = null;
		$participant_email_error = null;

		//Post
		$participant_id = $_POST['participant_id'];
		$participant_type_code = $_POST['participant_type_code'];
		$participant_name = $_POST['participant_name'];
		$participant_lastname = $_POST['participant_lastname'];
		$participant_email = $_POST['participant_email'];

		//Validaciones de entrada
		$valid = true;

		if(empty($participant_id)){
			$participant_id_error = 'Por favor, inserte el id';
			$valid = false;
		}

		if(empty($participant_type_code)){
			$participant_type_code_error = 'Por favor, inserte el tipo de participante';
			$valid = false;
		}

		if(empty($participant_name)){
			$participant_name_error = 'Por favor, inserte el nombre del participante';
			$valid = false;
		}

		if(empty($participant_lastname)){
			$participant_lastname_error = 'Por favor, inserte el apellido';
			$valid = false;
		}

		if(empty($participant_email)) {
			$precioError = 'Por favor, inserte la dirección';
			$valid = false;
		} elseif(!filter_var($participant_email,FILTER_VALIDATE_EMAIL)) {
			$precioError = 'Inserte una dirección de email valida';
			$valid = false;
		}

		if($valid) {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "UPDATE INTO participants SET participant_id = ?, participant_type_code = ?, participant_name = ?, participant_lastname = ?, participant_email = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($participant_id,$participant_type_code,$participant_name,$participant_lastname,$participant_email));
			Database::disconnect();
			header("Location: ../participantes.php");
		} else {
			$pdo = Database::connect();
			$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$sql = "SELECT * FROM participants WHERE participant_id = ?";
			$q = $pdo->prepare($sql);
			$q->execute(array($matricula));
			$data = $q->fetch(PDO::FETCH_ASSOC);
			$matricula = $data['participant_id'];
			$marca = $data['participant_type_code'];
			$modelo = $data['participant_name'];
			$color = $data['participant_type_code'];
			$precio = $data['participant_email'];
			Database::disconnect();
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf8">
	<link rel="stylesheet" href="../css/bootstrap.min.css">
	<script src="../js/bootstrap.min.js" type="text/javascript"></script>
	<title>Modificar</title>
</head>
<body>
	<div class="container">
		<div class="span10 offset1">
			<div class="row">
				<h3>Modificar Participante</h3>
			</div>

			<form class="form-horizontal" action="create.php" method="post">
				<!--*****************id*****************************-->
				<div class="control-group <?php echo !empty($participant_id_error)?'error':'';?>">
					<label class="control-label">Id</label>
					<div class="controls">
						<input name="participant_id" type="text" placeholder="id" value="<?php echo !empty($participant_id)?$participant_id:'';?>">
						<?php if(!empty($participant_id_error)): ?>
							<span class="help-inline"><?php echo $participant_id_error; ?></span>
						<?php endif; ?>
					</div>
				</div>
				<!--//******************Puesto*****************************/-->
				<div class="control-group <?php echo !empty($participant_type_code_error)?'error':'';?>">
					<label class="control-label">Puesto</label>
					<div class="controls">
						<input name="participant_type_code" type="text" placeholder="Puesto" value="<?php echo !empty($participant_type_code)?$participant_type_code:'';?>">
						<?php if(!empty($participant_type_code_error)): ?>
							<span class="help-inline"><?php echo $participant_type_code_error; ?></span>
						<?php endif; ?>
					</div>
				</div>
				<!--//*******************Nombre*************************/-->
				<div class="control-group <?php echo !empty($participant_name_error)?'error':'';?>">
					<label class="control-label">Nombre</label>
					<div class="controls">
						<input name="participant_name" type="text" placeholder="Nombre" value="<?php echo !empty($participant_name)?$participant_name:'';?>">
						<?php if(!empty($participant_name_error)): ?>
							<span class="help-inline"><?php echo $participant_name_error; ?></span>
						<?php endif; ?>
					</div>
				</div>
				<!---/********************Apellido***************************/-->
				<div class="control-group <?php echo !empty($participant_lastname_error)?'error':'';?>">
					<label class="control-label">Apellido</label>
					<div class="controls">
						<input name="participant_lastname" type="text" placeholder="Apellido" value="<?php echo !empty($participant_lastname)?$participant_lastname:'';?>">
						<?php if(!empty($participant_lastname_error)): ?>
							<span class="help-inline"><?php echo $participant_lastname_error; ?></span>
						<?php endif; ?>
					</div>
				</div>
				<!--/**********************Direccion**********************/-->
				<div class="control-group <?php echo !empty($participant_email_error)?'error':'';?>">
					<label class="control-label">Dirección de correo electronico</label>
					<div class="controls">
						<input name="participant_email" type="text" placeholder="ejemplo@email.com" value="<?php echo !empty($participant_email)?$participant_email:'';?>">
						<?php if(!empty($participant_email_error)): ?>
							<span class="help-inline"><?php echo $participant_email_error; ?></span>
						<?php endif; ?>
					</div>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-success">Crear</button>
					<a class="btn" href="../participantes.php">Regresar</a>
				</div>
			</form>	
		</div>
	</div> <!-- Contenedor -->
</body>
</html>