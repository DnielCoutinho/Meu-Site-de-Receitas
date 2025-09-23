<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../../config.php';
?>

<div class="container">
    <h1>Resultados da Busca</h1>

    <div class="lista-receitas">
        <?php
        if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
            $query = trim($_GET['q']);
            echo "<p class='termo-busca'>Você buscou por: <strong>" . htmlspecialchars($query) . "</strong></p>";

            $receitas_encontradas = [];

            // Se a busca contém vírgula, usamos a lógica de múltiplos ingredientes
            if (strpos($query, ',') !== false) {
                $ingredientes_busca = array_map('trim', explode(',', strtolower($query)));
                $ingredientes_busca = array_filter($ingredientes_busca);
                $ingredientes_busca = array_unique($ingredientes_busca);

                if (!empty($ingredientes_busca)) {
                    $conditions = [];
                    $params = [];
                    $types = '';
                    foreach ($ingredientes_busca as $ingrediente) {
                        $conditions[] = "ingredientes LIKE ?";
                        $params[] = "%" . $ingrediente . "%";
                        $types .= 's';
                    }
                    $where_clause = implode(' OR ', $conditions);

                    $sql = "SELECT id, nome, ingredientes, foto FROM receitas WHERE $where_clause";
                    $stmt = $conn->prepare($sql);
                    if ($stmt) {
                        $stmt->bind_param($types, ...$params);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $matches = 0;
                                $ingredientes_receita = strtolower($row['ingredientes']);
                                foreach ($ingredientes_busca as $ingrediente) {
                                    if (strpos($ingredientes_receita, $ingrediente) !== false) {
                                        $matches++;
                                    }
                                }
                                $row['matches'] = $matches;
                                $receitas_encontradas[$row['id']] = $row;
                            }
                        }
                        $stmt->close();
                    }
                }
                
                if (!empty($receitas_encontradas)) {
                    // Agrupar por nome para remover duplicatas visuais
                    $unique_by_name = [];
                    foreach($receitas_encontradas as $receita) {
                        if (!isset($unique_by_name[$receita['nome']]) || $receita['matches'] > $unique_by_name[$receita['nome']]['matches']) {
                           $unique_by_name[$receita['nome']] = $receita;
                        }
                    }
                    $receitas_encontradas = array_values($unique_by_name);

                    usort($receitas_encontradas, function($a, $b) {
                        return $b['matches'] <=> $a['matches'];
                    });
                }

            // Senão, fazemos uma busca simples por nome ou ingrediente único
            } else {
                $search_term = "%$query%";
                // Adicionado GROUP BY nome para evitar mostrar receitas com nomes idênticos
                $stmt = $conn->prepare("SELECT MAX(id) as id, nome, foto FROM receitas WHERE nome LIKE ? OR ingredientes LIKE ? GROUP BY nome");
                if ($stmt) {
                    $stmt->bind_param("ss", $search_term, $search_term);
                    $stmt->execute();
                    $result = $stmt->get_result();
                    if ($result->num_rows > 0) {
                        while ($receita = $result->fetch_assoc()) {
                            $receitas_encontradas[$receita['id']] = $receita;
                        }
                    }
                    $stmt->close();
                }
            }

            // Lógica de exibição unificada
            if (!empty($receitas_encontradas)) {
                echo "<div class='grid-receitas'>";
                foreach ($receitas_encontradas as $receita) {
                    echo "<div class='card-receita'>";
                    echo "<a href='visualizar_receita.php?id=" . $receita['id'] . "'>";
                    if (!empty($receita['foto'])) {
                        echo "<img src='/coutopasta/uploads/receitas/" . htmlspecialchars($receita['foto']) . "' alt='" . htmlspecialchars($receita['nome']) . "'>";
                    } else {
                        echo "<img src='/coutopasta/assets/placeholder.svg' alt='Imagem não disponível'>";
                    }
                    echo "<h3>" . htmlspecialchars($receita['nome']) . "</h3>";
                    if (isset($receita['matches'])) {
                        echo "<p class='matches'>Combina com <strong>" . $receita['matches'] . "</strong> dos seus ingredientes.</p>";
                    }
                    echo "</a>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<p>Nenhuma receita encontrada para o termo \"" . htmlspecialchars($query) . "\".</p>";
            }

        } else {
            echo "<p>Por favor, digite um termo para buscar.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>

<style>
.termo-busca {
    margin-bottom: 2rem;
    font-size: 1.2rem;
    text-align: center;
}
.grid-receitas {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 1.5rem;
}
.card-receita .matches {
    color: #28a745;
    font-weight: bold;
    font-size: 0.9rem;
}
</style>

<?php
include __DIR__ . '/../includes/footer.php';
?>
