<!-- Conexión a la base de datos,
codificación de caracteres,
seleccion de base de datos. -->

<?php 
    $conexion = mysqli_connect("localhost", "root", "", "gestion_bodega") or  die("Error al conectar a Base de Datos");
    mysqli_set_charset($conexion, 'utf8');
?>
