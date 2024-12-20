<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
	<title>Portal</title>
	<link rel="stylesheet" type="text/css" href="style2.css">
	<link href="https://fonts.googleapis.com/css2?family=Jost:wght@500&display=swap" rel="stylesheet">
</head>

<body>
	<div id="contenido">
		<div class="main">
			<input type="checkbox" id="chk" aria-hidden="true">

			<div class="signup ">
				<form id="registrationForm" action="register.php" method="POST">
					<label for="chk" aria-hidden="true">Registrar</label>

					<input type="text" id="rut" name="rut" placeholder="Rut: 11111111-1" required>

					<input type="text" id="nombre" name="nombre" placeholder="Nombre" required>

					<input type="text" id="apellido" name="apellido" placeholder="apellido" required>

					<input type="number" min="0" max="100" id="edad" name="edad" placeholder="edad" required>

					<input type="email" name="email" placeholder="Email" required>

					<input type="password" id="password" name="password" placeholder="Contra :D" required>

					<button>Sign up</button>

				</form>

			</div>

			<div class="login">
				<form action="login.php" method="POST">
					<label for="chk" aria-hidden="true">Ingresar</label>
					<input type="email" id="email" name="email" placeholder="Email" required>
					<input type="password" id="password" name="password" placeholder="Contra :D" required>
					<button>Login</button>
				</form>


				<div class="eyes-container">
					<div class="eye">
						<div class="upper-pupil"></div>
						<div class="iris"></div>
						<div class="lower-pupil"></div>
					</div>
					<div class="eye">
						<div class="upper-pupil"></div>
						<div class="iris"></div>
						<div class="lower-pupil"></div>
					</div>
				</div>
			</div>
			<?php
			// Si hay un mensaje de error almacenado en la sesión, mostrar la alerta
			if (isset($_SESSION['error_message'])):
				echo "<script>alert('{$_SESSION['error_message']}');</script>";
				// Eliminar el mensaje de error para que no se muestre en la siguiente carga de página
				unset($_SESSION['error_message']);
			endif;
			?>
		</div>
		<!-- Fondo de estrellas -->
		<div class=""></div>
		<div class="moving-stars"></div>
		<div class="stars"></div>

		<div class="moving-stars"></div>
		<div class="stars-2"></div>
		<div class="moving-stars-2"></div>

		<div class="stars"></div>
		<div class="moving-stars"></div>
		<div class="stars"></div>

		<div style="margin: 50px;
    color: #f71b1b;
    border: 1px solid #c0392b;
    border-radius: 5px;
    padding: 10px;
    margin-top: 10px;
    max-width: 300px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
	display: none;"
			id="messageContainer" class="error-message"></div> <!-- Contenedor para mensajes de error -->
	</div>
	<script src="login-register.js"></script>

	<div class="loader" id="preloader"></div>
</body>

</html>