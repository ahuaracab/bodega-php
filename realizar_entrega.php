<?php
    include 'sesion.php';
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

                    <?php
                        echo $_SESSION['nombre'].' '.$_SESSION['apellido'];
                    ?>

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

                include 'conexion.php';

                $consulta = "SELECT * FROM productos";
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
                    //se recupera valor de rut enviado por el formulario
					$rut = $_POST['rut'];
					//se consulta por la existencia del personal con el rut enviado en la base de datos	
					$consulta = "SELECT * FROM personal WHERE rut='$rut'";
                    $ejecutar = $mysqli->query($consulta) or die("Personal no encontrado");
                    $resul = $ejecutar->num_rows;

                    if ($resul > 0) { //valida que se encontró al personal en la base de datos
                        //se recupera valor de código del producto enviado por el formulario
                        $codigo = $_POST['codigo'];
						//se consulta por la existencia del producto con el código enviado, en la base de datos	
                        $consulta = "SELECT * FROM productos WHERE cod_producto='$codigo'";
                        $ejecutar = $mysqli->query($consulta) or die("Producto no encontrado");
                        $resul = $ejecutar->num_rows;
    
                        if($resul > 0) { //valida que se encontró el producto en la base de datos
                            //Se recupera el stock del producto que se va a actualizar
                            $result = $ejecutar->fetch_assoc();
                            $stock = $result['stock'];

                            if( $stock > 0) { //Se valida que el producto tenga stock disponible
                                //se recuperan la cantidad del producto que se va a retirar 
                                $cantidad = $_POST['cantidad'];

                                if ($cantidad <= $stock){ //se valida que se retire una cantidad menor o igual al stock
                                    //se recuperan la fecha en la que se va a retirar el producto
                                    $fecha = $_POST['fecha'];
                                    //Se realiza el registro de la entrega en la base de datos en la tabla entregas
                                    $consulta = "INSERT INTO entregas (rut, cod_producto, cantidad, fecha_entrega) VALUES ('$rut', '$codigo', '$cantidad', '$fecha')";
                                    $ejecutar = $mysqli->query($consulta) or die("No se pudo registrar la entrega");
                                        
                                    $stock = $stock - $cantidad; //Se descuenta la cantidad retirada al stock
                                    //Se actualiza el nuevo stock del producto en la base de datos en la tabla productos
                                    $consulta = "UPDATE productos SET stock = '$stock' WHERE cod_producto = '$codigo'";
                                    $ejecutar = $mysqli->query($consulta) or die("No se pudo actualizar el producto");
                                
                                    echo "Entrega añadida correctamente ";
                                    header("Location:realizar_entrega.php"); // se redirecciona a la misma vista realizar_entrega
                                } else {
                                    echo "Solo se puede retirar como máximo la totalidad del stock disponible";
                                }
                                                     
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