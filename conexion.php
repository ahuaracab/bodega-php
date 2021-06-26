<!-- Conexión a la base de datos,
codificación de caracteres,
seleccion de base de datos. -->

<?php 

    $mysqli = new mysqli('localhost', 'root', '', 'gestion_bodega');
    $mysqli->set_charset("utf8");

?>