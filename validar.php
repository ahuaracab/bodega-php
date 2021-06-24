<?php
	include ('conexion.php');

	$usuario = $_POST['usuario'];
	$pass = md5($_POST['pass']);

	$consulta = "SELECT * FROM personal WHERE rut = '$usuario' AND contraseña = '$pass'";
	$ejecutar = mysqli_query($conexion, $consulta);

	$resul = mysqli_num_rows($ejecutar);
	if ($resul > 0){

		session_start();
		$result = mysqli_fetch_assoc($ejecutar);
		$_SESSION['activo'] = true;
		$_SESSION['usuario'] = $usuario;
		$_SESSION['cargo'] = $result['cargo'];
		$_SESSION['nombre'] = $result['nombre'];
		$_SESSION['apellido'] = $result['apellido'];
		
		if ($result['cargo'] == 'Admin') {
			header("Location:principalAdmin.php");
		} else if ($result['cargo'] == 'Bodega') {
			header("Location:principalBodega.php");			
		}
	} else {
		header("Location:login.php?error=si");
	}

?>


