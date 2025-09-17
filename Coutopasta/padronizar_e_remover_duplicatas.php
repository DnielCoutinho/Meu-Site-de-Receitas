<?php
require_once('config.php');
// 1. Padronizar nomes para MAIÚSCULAS com acentos
function normalize_name($name) {
    $name = trim($name);
    $name = preg_replace('/\s+/', ' ', $name);
    $name = mb_strtoupper($name, 'UTF-8');
    return $name;
}
$sql = "SELECT id, nome FROM receitas";
$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $normalized = normalize_name($row['nome']);
        if ($normalized !== $row['nome']) {
            $update = $conn->prepare("UPDATE receitas SET nome = ? WHERE id = ?");
            $update->bind_param("si", $normalized, $row['id']);
            $update->execute();
            $update->close();
        }
    }
}

// 2. Remover duplicatas mantendo apenas a receita mais recente para cada nome
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
    $delete_sql = "DELETE FROM receitas WHERE id NOT IN ($ids_str) AND nome IN (SELECT nome FROM (SELECT nome FROM receitas GROUP BY nome HAVING COUNT(*) > 1) as dup)";
    $conn->query($delete_sql);
}

echo "Padronização e remoção de duplicatas concluídas.";
$conn->close();
?>