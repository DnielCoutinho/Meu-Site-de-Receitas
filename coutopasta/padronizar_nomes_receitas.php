<?php
require_once('config.php');

// Remove espaços extras, normaliza acentuação e deixa o nome em minúsculas para padronizar
function normalize_name($name) {
    $name = trim($name);
    $name = preg_replace('/\s+/', ' ', $name); // Remove espaços duplicados
    $name = mb_strtoupper($name, 'UTF-8'); // Deixa tudo em maiúsculas, mantém acentos
    return $name;
}

$sql = "SELECT id, nome FROM receitas";
$result = $conn->query($sql);

$updates = 0;
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $normalized = normalize_name($row['nome']);
        if ($normalized !== $row['nome']) {
            $update = $conn->prepare("UPDATE receitas SET nome = ? WHERE id = ?");
            $update->bind_param("si", $normalized, $row['id']);
            if ($update->execute()) {
                $updates++;
            }
            $update->close();
        }
    }
}

if ($updates > 0) {
    echo "Nomes de receitas padronizados: $updates atualizações.";
} else {
    echo "Nenhuma atualização necessária. Todos os nomes já estão padronizados.";
}

$conn->close();
?>
