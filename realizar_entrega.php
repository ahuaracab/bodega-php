<?php
    include ('sesion.php');
?>

<!DOCTYPE html> 
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Entregas</title>
        <link type="text/css" href="estilo.css" rel="stylesheet">
    </head>

    <body>
        <div class="contenedor">
            <div class= "encabezado">
                <div class="izq">
                    <p>Bienvenido/a:<br></p>
                    <?php echo $_SESSION['nombre'].' '.$_SESSION['apellido']; ?>
                </div>

                <div class="centro">
                    <a href=principalBodega.php><img src='imagenes/home.png'><br>Home</a>
                </div>
                
                <div class="derecha">
                    <a href="salir.php?sal=si"><img src="imagenes/cerrar.png"><br>Salir</a>
                </div>
            </div>                
            
            <br><h1 align='center'>PRODUCTOS EXISTENTES</h1><br>
            <?php
                include('conexion.php');

                $consulta = "SELECT * FROM productos";
                $ejecutar = mysqli_query($conexion, $consulta);
        
                echo "<table  width='80%' align='center'><tr>";               
                echo "<th width='10%'>CODIGO PRODUCTO</th>";
                echo "<th width='20%'>DESCRIPCIÓN</th>";
                echo "<th width='10%'>STOCK</th>";
                echo "<th width='20%'>PROVEEDOR</th>";
                echo "<th width='20%'>FECHA DE INGRESO</th>";
                echo  "</tr>"; 
            
                while($result = mysqli_fetch_assoc($ejecutar)){    
                    
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

            <form action="" method="post" align='center'>

                <div class="campo">
                    <label name="rut">Rut personal que retira:</label>
                    <input name='rut' type="text">
                </div>

                <div class="campo">
                    <label name="cod">Código del producto:</label>
                    <input name='codigo' type="text">
                </div>

                <div class="campo">
                    <label name="cantd">Cantidad:</label>
                    <input name='cantidad' type="text">
                </div>

                <div class="campo">
                    <label name="cantd">Fecha entrega:</label>
                    <input name='fecha' type="date">
                </div>
                
                <div class="botones">
                    <input name='agregar' type="submit" value="Agregar">
                </div>
                
            </form>          

            <!--Completar el Código que se requerirá a continuación--> 
            <!--Se verifica que la variable del boton submit este creada y se requiere:
            Recuperar las variables con los datos ingresados. 
            Descontar la cantidad ingresada al stock existente del producto a retirar.
            Insertar los datos ingresados en la tabla "entregas" de la base de datos. 
            Redirigir el flujo a esta misma página para visualizar la actualización del stock.-->    

            <?php           
                
                if (isset($_POST['agregar'])) {
                    //Las siguientes dos líneas de código recuperan las variables de stock.
					$rut = $_POST['rut'];
						
					$consulta = "SELECT * FROM personal WHERE rut='$rut'";
					$ejecutar = mysqli_query($conexion, $consulta);
					$resul = mysqli_num_rows($ejecutar);

                    if($resul > 0) {

                        $codigo = $_POST['codigo'];
						
                        $consulta = "SELECT * FROM productos WHERE cod_producto='$codigo'";
                        $ejecutar = mysqli_query($conexion, $consulta);
                        $resul = mysqli_num_rows($ejecutar);
    
                        if($resul > 0) {

                            $result = mysqli_fetch_assoc($ejecutar);
                            $stock = $result['stock'];

                            if( $stock > 0) {

                                $cantidad = $_POST['cantidad'];
                                $fecha = $_POST['fecha'];

                                $consulta = "INSERT INTO entregas (rut, cod_producto, cantidad, fecha_entrega) VALUES ('$rut', '$codigo', '$cantidad', '$fecha')";
                                $ejecutar = mysqli_query($conexion, $consulta) or die ("No se pudo crear el registro");
                                    
                                $stock = $stock - $cantidad;

                                $consulta = "UPDATE productos SET stock = '$stock' WHERE cod_producto = '$codigo'";
					            $ejecutar = mysqli_query($conexion, $consulta);
							
						        echo "Entrega añadida correctamente ";
                                header("Location:realizar_entrega.php");
                                                     
                            } else {
                                echo "El producto no tiene stock";
                            }
                        } else {
                            echo "No existe un producto con el código ingresado";
                        } 
                    } else {
						echo "No existe un personal con el rut ingresado";
					}
                }
            ?>                
        </div>
    </body>
</html> 