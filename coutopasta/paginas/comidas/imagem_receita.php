<?php
require_once('../../config.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    http_response_code(404);
    exit('ID inválido');
}
$receita_id = intval($_GET['id']);

$sql = "SELECT foto FROM receitas WHERE id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $receita_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($foto);
    $stmt->fetch();
    if ($foto) {
        header('Content-Type: image/jpeg');
        echo $foto;
        exit;
    }
}
// Se não houver imagem, retorna um placeholder
header('Content-Type: image/png');
readfile('../../img/placeholder.png');
exit;
?>
