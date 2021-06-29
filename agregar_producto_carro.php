<?php
    include 'sesion.php';
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Agregar productos a la web</title>
        <link rel="stylesheet" href="estilo.css"/>
    </head>
    <body>
        <div class="contenedor">
            <div class= "encabezado">
                <div class="izq">        
                    <p>Bienvenido/a:<br> </p>

                    <?php
                        echo $_SESSION['nombre'].' '.$_SESSION['apellido'];
                    ?>
                    
                </div>
                <div class="centro">

                    <?php

                        if ($_SESSION['cargo'] == 'Admin') {
                                echo "<a href=principalAdmin.php><center><img src='imagenes/home.png'><br>Home<center></a>";
                        } else {
                                echo "<a href=principalBodega.php><img src='imagenes/home.png'><br>Home</a>";
                        }

                        error_reporting(E_ALL  ^  E_NOTICE  ^  E_WARNING ^E_DEPRECATED );
                    ?>

                </div>            
                <div class="derecha">
                    <!-- La siguiente línea corresponde al link con imagen para finalizar sesión, que redirige a la página salir.php con la varible "sal=si" que destruye la sesión y nos 
                        muestra la pagina del login. -->
                    <a href="salir.php?sal=si"><img src="imagenes/cerrar.png"><br>Salir</a>
                </div>
            </div>
        
            <br><h1 align="center">GESTIÓN DE PRODUCTOS EN LA WEB</h1>

            <div class="formulario">
                <form action="" method="POST">
                    <div class="campo">
                        <label>Código Producto:</label>
                        <select name="codigos_producto">
                            <option selected value="1">Seleccione</option>
                        
                            <?php

                                include 'conexion.php';
                                $consulta = "SELECT * FROM productos";
                                $ejecutar = $mysqli->query($consulta);
                                foreach ($ejecutar as $producto) {
                                    echo "<option value=".$producto['cod_producto'].">".$producto['cod_producto']." - ". $producto['descripcion']."</option>";
                                }

                            ?>

                        </select>                    
                    </div>
                    <div class="campo">
                        <label for="desc_larga">Descripción: </label>
                        <textarea name="textarea" cols="40" rows="4" placeholder="Escribe la descripción aquí..." required="required"></textarea>
                    </div>
                    <div class="campo">
                        <label for="imagen">URL Imagen: </label>
                        <input type="text" name="img" required="required"/>
                    </div>
                    <div class="campo">
                        <label for="precio">Precio: </label>
                        <input type="number" name="precio" required="required"/>
                    </div>
                    <div>
                        <input type="submit" name="actualizar" value="Actualizar producto"/>
                    </div>
                </form>   
            </div>
        </div>     
    </body>
</html>

<?php

    if(isset($_POST['actualizar'])) {


        if( $codigos_producto != 1) {

            $consulta = "SELECT cod_producto FROM carrito_infos WHERE cod_producto=" . $_POST['codigos_producto'];
            $ejecutar = $mysqli->query($consulta);
            $resul = $ejecutar->num_rows;

            if ($resul == 0){

                $cod_producto = $_POST['codigos_producto'];
                $descripcion_larga = $_POST['textarea'];
                $precio = $_POST['precio'];
                $imagen = $_POST['img'];
    
                $consulta = "INSERT INTO carrito_infos VALUES (null, '$descripcion_larga', '$precio', '$imagen', '$cod_producto')";
                $ejecutar = $mysqli->query($consulta);
    
            } else {
                echo "<script type='text/javascript'>alert('Información ya existe')</script>";
            }

        } else {
            echo "<script type='text/javascript'>alert('Código no existente')</script>";
        }
    }

?>