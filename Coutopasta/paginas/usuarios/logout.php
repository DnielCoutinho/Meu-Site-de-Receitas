<?php
session_start();
session_destroy();
header("Location: /coutopasta/"); // Redireciona para a página principal
exit();
?>
