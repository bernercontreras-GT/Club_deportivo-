<?php
session_start();
require_once '../config/config.php';
//verificaremos si no exite una sesion abierta, solamente redirija a los usuarios activos al archivo index caso contrario al archivo login
if(!isset($_SESSION['usuario_id'])){
    header('Location: ./login.php');
    exit;
}
?>