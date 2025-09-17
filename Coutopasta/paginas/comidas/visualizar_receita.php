<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Verifica se o ID da receita foi passado e é um número
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h2>Receita não encontrada</h2><p>O ID da receita é inválido ou não foi fornecido.</p>";
    require_once('../includes/footer.php');
    exit();
}

$receita_id = intval($_GET['id']);

// Busca os detalhes completos da receita, AGORA INCLUINDO O r.usuario_id
$sql = "SELECT 
            r.id,
            r.nome, 
            r.ingredientes, 
            r.preparo, 
            r.foto,
            r.info_adicional,
            r.usuario_id,
            p.nome AS pais_nome, 
            tr.nome AS tipo_refeicao_nome,
            c.nome AS categoria_nome
        FROM receitas AS r
        JOIN paises AS p ON r.pais_id = p.id
        JOIN tipos_refeicao AS tr ON r.tipo_refeicao_id = tr.id
        JOIN categorias AS c ON r.categoria_id = c.id
        WHERE r.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $receita_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $receita = $result->fetch_assoc();
?>
    <div class="receita-view container">

        <h2><?php echo htmlspecialchars($receita['nome']); ?></h2>

        <div class="receita-meta">
            <span><strong>País:</strong> <?php echo htmlspecialchars($receita['pais_nome']); ?></span>
            <span><strong>Tipo de Refeição:</strong> <?php echo htmlspecialchars($receita['tipo_refeicao_nome']); ?></span>
            <span><strong>Categoria:</strong> <?php echo htmlspecialchars($receita['categoria_nome']); ?></span>
        </div>

        <?php 
        // Lógica de permissão simplificada e corrigida
        $pode_editar = false;
        if (isset($_SESSION['usuario_id'])) {
            $is_owner = isset($receita['usuario_id']) && $_SESSION['usuario_id'] == $receita['usuario_id'];
            $is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
            if ($is_owner || $is_admin) {
                $pode_editar = true;
            }
        }
        
        if ($pode_editar): 
        ?>
            <div class="receita-actions" style="text-align: center; margin-bottom: 20px;">
                <a href="editar_receita.php?id=<?php echo $receita_id; ?>" class="btn">Editar Receita</a>
                <a href="excluir_receita.php?id=<?php echo $receita_id; ?>" class="btn" onclick="return confirm('Tem certeza que deseja excluir esta receita? Esta ação não pode ser desfeita.');" style="background-color: #dc3545; border-color: #dc3545; color: white;">Excluir Receita</a>
            </div>
        <?php endif; ?>

        <div class="receita-details">
            <?php if (!empty($receita['foto'])): ?>
            <div class="receita-img">
                <img src="/coutopasta/uploads/receitas/<?php echo htmlspecialchars($receita['foto']); ?>" alt="Foto de <?php echo htmlspecialchars($receita['nome']); ?>" style="width: 100%; max-width: 600px; height: auto; border-radius: 8px; margin: 0 auto 20px; display: block;">
            </div>
            <?php endif; ?>

            <div class="ingredientes">
                <h3>Ingredientes</h3>
                <?php
                $ingredientes_texto = trim($receita['ingredientes']);
                if (!empty($ingredientes_texto)) {
                    echo '<ul>';
                    // Normaliza os separadores: substitui quebras de linha por vírgulas
                    $ingredientes_normalizado = str_replace(array("\r\n", "\r", "\n"), ",", $ingredientes_texto);
                    // Divide a string por vírgulas
                    $ingredientes_lista = explode(',', $ingredientes_normalizado);
                    
                    foreach ($ingredientes_lista as $ingrediente) {
                        $ingrediente_trim = trim($ingrediente);
                        if (!empty($ingrediente_trim)) {
                            echo '<li>' . htmlspecialchars($ingrediente_trim) . '</li>';
                        }
                    }
                    echo '</ul>';
                } else {
                    echo '<p>Nenhum ingrediente listado.</p>';
                }
                ?>
            </div>
            
            <div class="preparo">
                <h3>Modo de Preparo</h3>
                <div class="preparo-passos">
                    <?php
                    $preparo_texto = $receita['preparo'];
                    $linhas = preg_split('/?
/', $preparo_texto);
                    
                    $is_list_open = false;

                    foreach ($linhas as $linha) {
                        $linha_trim = trim($linha);
                        if (empty($linha_trim)) continue;

                        // Se a linha termina com ':', é um título de seção
                        if (substr($linha_trim, -1) === ':') {
                            if ($is_list_open) {
                                echo '</ol>'; // Fecha a lista anterior
                                $is_list_open = false;
                            }
                            echo '<h4 class="preparo-titulo-destaque">' . htmlspecialchars($linha_trim) . '</h4>'; // Título da seção com classe
                        } else {
                            if (!$is_list_open) {
                                echo '<ol class="preparo-lista">'; // Abre uma nova lista
                                $is_list_open = true;
                            }
                            // Formata o passo com destaque para texto entre **
                            $passo_formatado = preg_replace('/\*\*(.*?)\*\*/', '<span class="destaque">$1</span>', htmlspecialchars($linha_trim));
                            echo '<li>' . $passo_formatado . '</li>'; // Item da lista
                        }
                    }

                    if ($is_list_open) {
                        echo '</ol>'; // Fecha a última lista
                    }
                    ?>
                </div>
            </div>
        </div>

        <?php if (!empty($receita['info_adicional'])): ?>
        <div class="info-adicional">
            <h3>Informações adicionais</h3>
            <p><?php echo nl2br(htmlspecialchars($receita['info_adicional'])); ?></p>
        </div>
        <?php endif; ?>
    </div>
<?php
} else {
    echo "<h2>Receita não encontrada</h2><p>A receita que você está procurando não existe.</p>";
}

$stmt->close();
$conn->close();
require_once('../includes/footer.php');
?>