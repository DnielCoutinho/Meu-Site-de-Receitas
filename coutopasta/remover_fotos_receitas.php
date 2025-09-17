<?php
require_once('config.php');
// Remove todas as fotos das receitas
echo "Removendo todas as fotos das receitas...<br>";
$sql = "UPDATE receitas SET foto = ''";
if ($conn->query($sql) === TRUE) {
    echo "Todas as fotos removidas com sucesso.";
} else {
    echo "Erro ao remover fotos: " . $conn->error;
}
$conn->close();
?>
