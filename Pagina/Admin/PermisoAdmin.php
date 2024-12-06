<?php
require "../../database.php";
session_start();

// Verificar si el usuario está logueado y tiene rol de administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_rol'] != 0 && $_SESSION['user_rol'] != 2) {
    // Redirigir al inicio de sesión si no está autorizado
    header("Location: ../../home/home.php");
    exit;
}