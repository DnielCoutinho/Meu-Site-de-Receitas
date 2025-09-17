<?php
require_once('config.php');

// Remove duplicatas mantendo apenas a receita mais recente (maior id) para cada nome
$sql = "SELECT nome, MAX(id) as keep_id FROM receitas GROUP BY nome";
$result = $conn->query($sql);

$ids_to_keep = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $ids_to_keep[] = $row['keep_id'];
    }
}

if (!empty($ids_to_keep)) {
    $ids_str = implode(',', $ids_to_keep);
    // Exclui todas as receitas cujo id não está na lista de ids a manter
    $delete_sql = "DELETE FROM receitas WHERE id NOT IN ($ids_str) AND nome IN (SELECT nome FROM (SELECT nome FROM receitas GROUP BY nome HAVING COUNT(*) > 1) as dup)";
    if ($conn->query($delete_sql) === TRUE) {
        echo "Receitas duplicadas removidas com sucesso.";
    } else {
        echo "Erro ao remover duplicatas: " . $conn->error;
    }
} else {
    echo "Nenhuma duplicata encontrada para remover.";
}

$conn->close();
?>
