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
    include ('conexion.php'); //se realiza la conexión con la bd
    //se obtiene el rut para posteriormente consultar si existe en la tabla personal
    $rut = $_POST['rut'];
    $consulta = "SELECT * FROM personal WHERE rut = '$rut'";
    $ejecutar = mysqli_query($conexion, $consulta);
    
    $total = mysqli_num_rows($ejecutar);
    if($total > 0){ 
        header("Location:crear_personal.php?mensaje=si"); 
    } else if($_POST['contrasena1'] == $_POST['contrasena2']){ //se valida que las contraseñas coincidan
       // se obtienen los valores que fueron ingresados en los demás campos 
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $cargo = $_POST['cargo'];
        $contraseña = md5($_POST['contrasena1']);
        // se hace la inserción del registro a la tabla personal
        $query = "INSERT INTO personal(rut, nombre, apellido, cargo, contraseña)
        VALUES ('$rut', '$nombre', '$apellido', '$cargo', '$contraseña')";
        $ejecutar = mysqli_query($conexion, $query) or die('No se pudo crear el registro!');

        header("Location:crear_personal.php?valida=si"); //se redirecciona a la vista crear_personal con el parametro "valida" con el valor "si"
        
    } else {
        header("Location:crear_personal.php?erronea=si"); //se redirecciona a la vista crear_personal con el parametro "erronea" con el valor "si"
    }

?>