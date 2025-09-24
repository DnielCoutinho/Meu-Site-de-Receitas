<?php
session_start();
require_once('../../config.php'); // Adicionado para ter acesso à constante BASE_URL
session_destroy();
header("Location: " . BASE_URL . "/"); // Redireciona para a página principal
exit();
?>