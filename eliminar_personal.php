<?php
	include 'sesion.php';
?>

<!DOCTYPE html> 
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>formulario eliminar PERSONAL</title>
		<link type="text/css" href="estilo.css" rel="stylesheet">
	</head>
	<body>
		<div class="contenedor">
			<div class= "encabezado">
				<div class="izq">			
					<p>Bienvenido/a:<br></p>
						<?php
							echo $_SESSION['nombre'].' '.$_SESSION['apellido'];
						?>
				</div>
				<div class="centro">
					<a href=principalAdmin.php><center><img src='imagenes/home.png'><br>Home<center></a>
				</div>					
				<div class="derecha">
					<a href="salir.php?sal=si"><img src="imagenes/cerrar.png"><br>Salir</a>
				</div>
			</div>
		
			<br><br><h1 align='center'>REGISTROS EXISTENTES</h1><br>
			
			<?php

				include 'conexion.php';

				$consulta = "SELECT * FROM personal";
				$ejecutar = $mysqli->query($consulta) or die("Personal no encontrado");
			
				echo "<table  width='80%' align='center'><tr>";	         	  
				echo "<th width='20%'>RUT</th>";
				echo "<th width='20%'>NOMBRE</th>";
				echo "<th width='20%'>APELLIDO</th>";
				echo "<th width='20%'>CARGO</th>";
				echo  "</tr>"; 
			
				while($result = $ejecutar->fetch_assoc()) {					
					echo "<tr>";	         	  
					echo '<td width=20%>'.$result['rut'].'</td>';
					echo '<td width=20%>'.$result['nombre'].'</td>';
					echo '<td width=20%>'. $result['apellido'].'</td>';
					echo '<td width=20%>'.$result['cargo'].'</td>';
					echo "</tr>";
				}

				echo "</table></br>";

			?>

			<form action="" method="post" align='center'>
				<label name="elimina">Ingresa el Rut del personal a eliminar:</label>
				<input name='eliminar-personal' type="text">
				<input name='eliminar' type="submit" value="ELIMINAR">
			</form>
			
			<!--Completar el Código que se requerirá a continuación--> 	
			<!-- En las siguientes 5 lineas se verifica la creación del boton submit, 
			se recupera el rut ingresado para ser eliminado, se verifica si es igual al rut del Admin, 
			y se muestra alerta con mensaje-->	
			<?php

				if (isset($_POST['eliminar'])) { //se valida que la variable está definida
					$eliminar = $_POST['eliminar-personal']; //Se obtiene el rut enviado
					if ($eliminar == '180332403') { //Se valida si es el rut del admin, en caso sea, se envía un mensaje
						echo "<script lenguaje='javascript'>alert('Admin general no puede ser eliminado');</script>"; //mensaje indicando que no se puede eliminar al admin
					} else { //si el rut no es del admin se procede a eliminar al personal de la tabla personal de la bd
						$consulta = "DELETE FROM personal WHERE rut = '$eliminar'";
						$ejecutar = $mysqli->query($consulta) or die("No se puedo eliminar al personal");
						
						header("Location:eliminar_personal.php");
					}	
				}

			?>

		</div>
	</body>
</html>		 