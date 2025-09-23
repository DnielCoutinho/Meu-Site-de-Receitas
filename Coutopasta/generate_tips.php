<?php
require_once('config.php');

echo "<h1>Gerando Dicas Adicionais Personalizadas para Receitas</h1>";

function generatePersonalizedTip($receita) {
    $tip = "Dica para a receita de " . htmlspecialchars($receita['nome']) . ": ";

    // Dicas baseadas em ingredientes
    if (!empty($receita['ingredientes'])) {
        $ingredientes = explode(',', $receita['ingredientes']);
        if (count($ingredientes) > 2) {
            $tip .= "Considere a qualidade dos seus " . htmlspecialchars(trim($ingredientes[0])) . " e " . htmlspecialchars(trim($ingredientes[1])) . " para um sabor superior. ";
        }
    }

    // Dicas baseadas no modo de preparo (muito genérico, mas podemos tentar algo)
    if (!empty($receita['preparo'])) {
        if (strpos(strtolower($receita['preparo']), 'assar') !== false) {
            $tip .= "Ao assar, pré-aqueça bem o forno para garantir uma cocção uniforme. ";
        } elseif (strpos(strtolower($receita['preparo']), 'fritar') !== false) {
            $tip .= "Para frituras, use óleo na temperatura certa para evitar que o prato fique encharcado. ";
        }
    }

    // Dicas baseadas no país
    if (!empty($receita['pais_nome'])) {
        $tip .= "Esta receita de origem " . htmlspecialchars($receita['pais_nome']) . " combina muito bem com uma bebida típica da região. ";
    }

    // Dicas baseadas no tipo de refeição
    if (!empty($receita['tipo_refeicao_nome'])) {
        if (strtolower($receita['tipo_refeicao_nome']) == 'sobremesa') {
            $tip .= "Para uma sobremesa perfeita, o resfriamento adequado é crucial. ";
        } elseif (strtolower($receita['tipo_refeicao_nome']) == 'prato principal') {
            $tip .= "Sirva este prato principal com um acompanhamento leve para equilibrar a refeição. ";
        }
    }

    // Dicas baseadas na categoria
    if (!empty($receita['categoria_nome'])) {
        if (strtolower($receita['categoria_nome']) == 'vegetariano') {
            $tip .= "Para uma versão ainda mais rica, adicione mais vegetais da estação. ";
        }
    }

    // Dica genérica final se nenhuma específica foi adicionada
    if (strlen($tip) < 50) { // Se a dica ainda for muito curta
        $tip .= "Experimente adicionar um toque pessoal com seus temperos favoritos ou sirva com um acompanhamento diferente para variar!";
    }

    return $tip;
}


// Seleciona todas as receitas com detalhes adicionais
$sql_select = "SELECT 
                    r.id,
                    r.nome,
                    r.ingredientes,
                    r.preparo,
                    p.nome AS pais_nome,
                    tr.nome AS tipo_refeicao_nome,
                    c.nome AS categoria_nome
                FROM receitas AS r
                JOIN paises AS p ON r.pais_id = p.id
                JOIN tipos_refeicao AS tr ON r.tipo_refeicao_id = tr.id
                JOIN categorias AS c ON r.categoria_id = c.id";

$result_select = $conn->query($sql_select);

if ($result_select->num_rows > 0) {
    while ($receita = $result_select->fetch_assoc()) {
        $receita_id = $receita['id'];

        // Gera uma dica adicional personalizada
        $dica_adicional = generatePersonalizedTip($receita);

        // Atualiza o campo info_adicional no banco de dados
        $sql_update = "UPDATE receitas SET info_adicional = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);

        if ($stmt_update) {
            $stmt_update->bind_param("si", $dica_adicional, $receita_id);
            if ($stmt_update->execute()) {
                echo "<p>Receita ID: " . $receita_id . " - Dica adicionada com sucesso.</p>";
            } else {
                echo "<p style=\"color:red;\">Erro ao atualizar receita ID: " . $receita_id . " - " . $stmt_update->error . "</p>";
            }
            $stmt_update->close();
        } else {
            echo "<p style=\"color:red;\">Erro na preparação do statement de atualização: " . $conn->error . "</p>";
        }
    }
    echo "<h2>Processo concluído!</h2>";
} else {
    echo "<p>Nenhuma receita encontrada no banco de dados.</p>";
}

$conn->close();
?>