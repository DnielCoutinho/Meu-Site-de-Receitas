<?php
session_start();
require_once('../../config.php'); // Adicionado para ter acesso à constante BASE_URL
session_destroy();
header("Location: " . BASE_URL . "/paginas/usuarios/login.php"); // Redireciona para o login
exit();
?>