<?php
 $host = "localhost";
 $user = "root";
 $pass = "";
 $db = "club_deportivo";
 $mysqli = new mysqli("$host","$user","$pass","$db");

if($mysqli->connect_errno){
    die("Error de conexión".$mysqli->connect_error);
}
//else{
 //die("Conexion correcta");
 //}

$mysqli->set_charset("utf8mb4");

function limpiar($s){
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}
?>