<?php
include __DIR__ . '/../includes/header.php';
include __DIR__ . '/../../config.php';
?>

<div class="container">
    <div class="search-header">
        <h1>Resultados da Busca</h1>
        <?php if (isset($_GET['q']) && !empty(trim($_GET['q']))): ?>
            <p class="termo-busca">Você buscou por: <strong>"<?php echo htmlspecialchars(trim($_GET['q'])); ?>"</strong></p>
        <?php endif; ?>
    </div>

    <div class="lista-receitas">
        <?php
        if (isset($_GET['q']) && !empty(trim($_GET['q']))) {
            $query = trim($_GET['q']);
            $receitas_encontradas = [];

            // Lógica para busca por múltiplos ingredientes (com vírgula)
            if (strpos($query, ',') !== false) {
                $ingredientes_busca = array_map('trim', explode(',', strtolower($query)));
                $ingredientes_busca = array_filter($ingredientes_busca);
                $ingredientes_busca = array_unique($ingredientes_busca);

                if (!empty($ingredientes_busca)) {
                    $conditions = []; $params = []; $types = '';
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
                                // --- LÓGICA ATUALIZADA PARA ENCONTRAR NOMES ---
                                $matches = 0;
                                $matching_ingredients = [];
                                $ingredientes_receita = strtolower($row['ingredientes']);

                                foreach ($ingredientes_busca as $ingrediente_buscado) {
                                    if (strpos($ingredientes_receita, $ingrediente_buscado) !== false) {
                                        $matches++;
                                        $matching_ingredients[] = ucfirst($ingrediente_buscado); // Adiciona o nome do ingrediente à lista
                                    }
                                }
                                $row['matches'] = $matches;
                                $row['matching_ingredients'] = $matching_ingredients; // Armazena a lista de nomes
                                $receitas_encontradas[$row['id']] = $row;
                            }
                        }
                        $stmt->close();
                    }
                }
                
                // Ordena os resultados pelo número de ingredientes que combinaram
                if (!empty($receitas_encontradas)) {
                    uasort($receitas_encontradas, function($a, $b) {
                        return $b['matches'] <=> $a['matches'];
                    });
                }

            } else { // Lógica para busca simples (um termo)
                $search_term = "%$query%";
                $stmt = $conn->prepare("SELECT id, nome, foto FROM receitas WHERE nome LIKE ? OR ingredientes LIKE ?");
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
                echo "<div class='receitas-grid search-grid'>";
                foreach ($receitas_encontradas as $receita) {
                    echo "<article class='receita-card'>"; // Usando a mesma classe de card para consistência
                        echo "<a href='visualizar_receita.php?id=" . $receita['id'] . "' style='text-decoration: none; color: inherit; display: flex; flex-direction: column; height: 100%;'>";
                            echo "<img src='" . get_foto_src($receita['foto']) . "' alt='" . htmlspecialchars($receita['nome']) . "'>";
                            
                            // Container do conteúdo para alinhamento com flexbox
                            echo "<div class='receita-card-content'>";
                                echo "<h3>" . htmlspecialchars($receita['nome']) . "</h3>";
                                
                                // Seção de ingredientes (será empurrada para baixo)
                                if (isset($receita['matches']) && $receita['matches'] > 0) {
                                    echo "<div class='match-info'>";
                                        echo "<p class='match-count'>Combina com <strong>" . $receita['matches'] . "</strong> dos seus ingredientes:</p>";
                                        echo "<div class='match-tags'>";
                                        foreach ($receita['matching_ingredients'] as $ing) {
                                            echo "<span class='tag'>" . htmlspecialchars($ing) . "</span>";
                                        }
                                        echo "</div>";
                                    echo "</div>";
                                }

                            echo "</div>";
                        echo "</a>";
                    echo "</article>";
                }
                echo "</div>";
            } else {
                echo "<p class='no-results'>Nenhuma receita encontrada para o termo \"" . htmlspecialchars($query) . "\".</p>";
            }

        } else {
            echo "<p class='no-results'>Por favor, digite um termo para buscar.</p>";
        }
        $conn->close();
        ?>
    </div>
</div>

<?php
include __DIR__ . '/../includes/footer.php';
?>