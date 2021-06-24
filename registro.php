 <!--Completar el Código que se requerirá a continuación-->
 <!--Recuperar las variables con los datos ingresados en el formulario. 
  Validar que el rut ingresado no se encuantre en la base de datos.
  Si ya existe un registro vinculado al rut ingresado:
	 Redirigir a crear_personal y entregar mensaje.
  Si no existe:
	 Insertar datos en tabla correspondiente.
	 Redirigir a crear_personal y mostrar mensaje.
Si las contraseñas no coinciden redirigir a crear_personal y mostrar mensaje. --> 	
<?php
    include ('conexion.php');

    $rut = $_POST['rut'];
    $consulta = "SELECT * FROM personal WHERE rut = '$rut'";
    $ejecutar = mysqli_query($conexion, $consulta);
    
    $total = mysqli_num_rows($ejecutar);
    if($total > 0){ 
        header("Location:crear_personal.php?mensaje=si"); 
    } else if($_POST['contrasena1'] == $_POST['contrasena2']){
       
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $cargo = $_POST['cargo'];
        $contraseña = md5($_POST['contrasena1']);
        
        $query = "INSERT INTO personal(rut, nombre, apellido, cargo, contraseña)
        VALUES ('$rut', '$nombre', '$apellido', '$cargo', '$contraseña')";

        $ejecutar = mysqli_query($conexion, $query) or die('No se pudo crear el registro!');

        header("Location:crear_personal.php?valida=si");
        
    } else {
        header("Location:crear_personal.php?erronea=si");
    }

?>