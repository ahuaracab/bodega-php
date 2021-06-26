<?php
	include 'sesion.php';
?>

<!DOCTYPE html> 
<html>
	<head>
		<meta charset="UTF-8"/>
		<title>Modificar producto</title>
		<link type="text/css" href="estilo.css" rel="stylesheet">
	</head>
	<body>
		<div class="contenedor">
			<div class= "encabezado">
				<div class="izq">
					<p>Bienvenido/a:<br></p>

					<?php
						error_reporting(E_ALL  ^  E_NOTICE  ^  E_WARNING ^E_DEPRECATED );
						echo $_SESSION['nombre'].' '.$_SESSION['apellido'];
					?>

				</div>
				<div class="centro">

					<?php

						if ($_SESSION['cargo']=='Admin') {
							echo "<a href=principalAdmin.php><center><img src='imagenes/home.png'><br>Home<center></a>";
						} else {
							echo "<a href=principalBodega.php><img src='imagenes/home.png'><br>Home</a>";
						}

	       			?>
				
				</div>				
				<div class="derecha">
					<!-- La siguiente línea corresponde al links con imagen para finalizar sesión, que redirige a la página salir.php con la varible "sal=si" que destruye la sesión y nos 
					muestra la pagina del login. -->
					<a href="salir.php?sal=si"><img src="imagenes/cerrar.png"><br>Salir</a>
				</div>
			</div>

			<br><h1 align="center">PRODUCTOS EXISTENTES</h1><br>
			
			<?php

				include 'conexion.php';

				$consulta="SELECT * FROM productos";
				$ejecutar = $mysqli->query($consulta) or die("Datos no encontrados");
						
				echo "<table  width='80%' align='center'><tr>";	         	  
				echo "<th width='10%'>CODIGO PRODUCTO</th>";
				echo "<th width='20%'>DESCRIPCIÓN</th>";
				echo "<th width='10%'>STOCK</th>";
				echo "<th width='20%'>PROVEEDOR</th>";
				echo "<th width='20%'>FECHA DE INGRESO</th>";
				echo  "</tr>"; 
			
				while($result = $ejecutar->fetch_assoc()){							          	
					echo "<tr>";	         	  
					echo '<td width=10%>'.$result['cod_producto'].'</td>';
					echo '<td width=20%>'.$result['descripcion'].'</td>';
					echo '<td width=20%>'. $result['stock'].'</td>';
					echo '<td width=20%>'.$result['proveedor'].'</td>';
					echo '<td width=20%>'.$result['fecha_ingreso'].'</td>';
					echo "</tr>";
				}
				echo "</table></br>";
			?>

			<div class="encabezado">
	                <h1>Modificar producto</h1>
	        </div>

	        <div class="formulario">

	            <form name="actualizar" method="post" action="" enctype="application/x-www-form-urlencoded">
	           		<div class="campo">
	               		<p>Para actualizar el stock de un producto ingresa el código del producto y la cantidad que deseas agregar. Para quitar deber ingresar la cantidad anteponiendo el signo menos (-) a la cantidad</p><br><br>

	                    <label name="seleccionar">Ingresa el código del producto que deseas actualizar:</label>
			 			<input name='seleccionar' type="text" required>
	                </div>
	                <div class="campo">
	                    <div class="en-linea izquierdo">
	                    	<label for="descrip">Stock:</label>
	                        <input type="number" name="stock" required/>
	                    </div>
	                    <div class="en-linea">
	                        <label for="actualiza">Stock:</label>
	                        <input type="submit" name="actualiza" value="Actualizar" required/>
	                    </div>
	                </div>
	            </form>

	         	<!--Completar el Código que se requerirá a continuación--> 	
				<!--Se realiza la verificación del boton sumbit "actualiza" y se requiere:
				Recuperar las variables con los valores ingresados.
				Actualizar stock del producto seleccionado.
	            Redirigir a la misma página para visualizar los cambios. -->
				<?php
					// La siguiente línea de codigo verifica que la varible del boton submit "actualiza" este creada.	
					if (isset($_POST['actualiza'])) {
						//Se recupera el valor del código de producto enviado por el formulario
						$seleccionar = $_POST['seleccionar'];
						//Se consulta a la tabla productos de la base de datos para confirmar su existencia en ella
						$consulta = "SELECT * FROM productos WHERE cod_producto='$seleccionar'";
						$ejecutar = $mysqli->query($consulta) or die("Producto no encontrado");
						$resul = $ejecutar->num_rows;

						if ($resul > 0) { //Se valida si existe o no el producto con el código que se ingresó
							$result = $ejecutar->fetch_assoc();
							$stock = $_POST['stock']; //Se recupera el stock que se va a aumentar o disminuir
							$stock = $stock + $result['stock']; //Se agrega o quita el stock enviado al stock que se recuperó de la base de datos 
							
							if ($stock >= 0) { //se valida que no se intente quitar más stock del que tiene un producto
								//Se realiza la actualizción de stock en la base de datos
								$consulta = "UPDATE productos SET stock = '$stock' WHERE cod_producto = '$seleccionar'";
								$ejecutar = $mysqli->query($consulta) or die("No se pudo actualizar el producto");
								
								header("Location:mod_producto.php"); //Se redirecciona a la misma vista mod_producto
							} else {
								echo "Hay menos stock del que intentas quitar";
							}
						} else {
							echo "No existe un producto con el código ingresado";
						}
					}

				?>
	            	
	            <form name="modificar" method="post" action="" enctype="application/x-www-form-urlencoded">
	                <div class="campo">
	                    <label name="Seleccionar">Ingresa el código del producto que deseas modificar:</label>
			 			<input name='seleccionar' type="text" required>
	                </div>
	                <div class="campo">
	                    <label for="descrip">Descripción:</label>
	                    <input type="text" name="descripcion" required/>
	                </div>
	                <div class="campo">
	                    <label for="cargo">Proveedor:</label>
		                <input type="text" name="proveedor" required/>
	                </div>
	                <div class="campo">
	                    <label for="cargo">Fecha ingreso:</label>
		                <input type="date" name="fecha" required/>
	                </div>
	                <div class="botones">
	                    <input type="submit" name="modificar" value="Modificar"/>
					</div>
				</form>
				
				 <!--Completar el Código que se requerirá a continuación--> 
				 <!--Se realiza la verificación del boton submit "modificar" y se requiere:	
				 Recuperar las variables con los valores ingresados.
				 Realizar modificación de datos en la tabla correspondiente. 
				 Redirigir el flujo a esta misma página para visualizar los cambios-->
				<?php 
					if (isset($_POST['modificar'])) {
						//Se recupera el valor del código de producto enviado por el formulario
						$seleccionar = $_POST['seleccionar'];
						//Se consulta a la tabla productos de la base de datos para confirmar su existencia en ella
						$consulta = "SELECT * FROM productos WHERE cod_producto='$seleccionar'";
						$ejecutar = $mysqli->query($consulta) or die("Datos no encontrados");
						$resul = $ejecutar->num_rows;

						if($resul > 0){ //Se valida si existe o no el producto con el código que se ingresó
							//se recuperar los valores de descripcion, proveedor y fecha enviados por el formulario
							$descripcion = $_POST['descripcion'];
							$proveedor = $_POST['proveedor'];
							$fecha = $_POST['fecha'];
							//se realiza la actualización de los valores en la base de datos
							$consulta = "UPDATE productos SET descripcion = '$descripcion', proveedor = '$proveedor', fecha_ingreso = '$fecha' WHERE cod_producto = '$seleccionar'";
							$ejecutar = $mysqli->query($consulta) or die("No se pudo actualizar el producto");

							// header("Location:mod_producto.php");
							//Se agregó la siguiente llamada a mod_producto.php porque la función header anterior no actualizaba la tabla que muestran datos de los productos
							echo"<script language='javascript'>window.location='mod_producto.php'</script>;";

						} else {
							echo "No existe un producto con el código ingresado";
						}
                	}	
				?>

			</div>
		</div>
	</body>
</html>