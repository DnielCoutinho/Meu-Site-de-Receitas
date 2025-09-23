<?php
require_once('config.php');

echo "<h1>Lista de Receitas para Geração de Dicas</h1>";
echo "<pre>";

$sql_select = "SELECT id, nome FROM receitas ORDER BY id ASC";
$result_select = $conn->query($sql_select);

if ($result_select->num_rows > 0) {
    while ($receita = $result_select->fetch_assoc()) {
        echo "ID: " . $receita['id'] . ", Nome: " . htmlspecialchars($receita['nome']) . "\n";
    }
} else {
    echo "Nenhuma receita encontrada no banco de dados.";
}

echo "</pre>";
$conn->close();
?>
