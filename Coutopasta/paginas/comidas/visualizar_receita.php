<?php
require_once('../includes/header.php');
require_once('../../config.php');

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<div class='container'><h2>Receita não encontrada</h2><p>O ID da receita é inválido ou não foi fornecido.</p></div>";
    require_once('../includes/footer.php');
    exit();
}

$receita_id = intval($_GET['id']);
$sql = "SELECT r.*, p.nome AS pais_nome, tr.nome AS tipo_refeicao_nome, c.nome AS categoria_nome FROM receitas r JOIN paises p ON r.pais_id = p.id JOIN tipos_refeicao tr ON r.tipo_refeicao_id = tr.id JOIN categorias c ON r.categoria_id = c.id WHERE r.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $receita_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $receita = $result->fetch_assoc();
?>
    <div class="receita-view">
        <h2><?php echo htmlspecialchars($receita['nome']); ?></h2>

        <div class="receita-meta">
            <span><strong>País:</strong> <?php echo htmlspecialchars($receita['pais_nome']); ?></span>
            <span><strong>Tipo:</strong> <?php echo htmlspecialchars($receita['tipo_refeicao_nome']); ?></span>
            <span><strong>Categoria:</strong> <?php echo htmlspecialchars($receita['categoria_nome']); ?></span>
        </div>

        <?php 
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
            <div class="receita-actions">
                <a href="editar_receita.php?id=<?php echo $receita_id; ?>" class="btn">Editar Receita</a>
                <a href="excluir_receita.php?id=<?php echo $receita_id; ?>" class="btn btn-excluir" onclick="return confirm('Tem certeza que deseja excluir esta receita?');">Excluir Receita</a>
            </div>
        <?php endif; ?>

        <div class="receita-img">
            <img src="<?php echo get_foto_src($receita['foto']); ?>" alt="Foto de <?php echo htmlspecialchars($receita['nome']); ?>">
        </div>

        <div class="receita-details">
            <div class="ingredientes">
                <h3>Ingredientes</h3>
                <ul>
                <?php
                // --- NOVA LÓGICA INTELIGENTE PARA INGREDIENTES ---
                $texto_ingredientes = $receita['ingredientes'];
                $ingredientes_lista = [];

                // Verifica se o texto tem quebras de linha. Se tiver, usa-as como separador.
                if (strpos($texto_ingredientes, "\n") !== false || strpos($texto_ingredientes, "\r") !== false) {
                    $texto_normalizado = str_replace(["\r\n", "\r"], "\n", $texto_ingredientes);
                    $ingredientes_lista = explode("\n", $texto_normalizado);
                } else {
                    // Se não tiver quebras de linha, usa a vírgula como separador.
                    $ingredientes_lista = explode(",", $texto_ingredientes);
                }

                foreach ($ingredientes_lista as $ingrediente) {
                    // Remove hífens e outros marcadores comuns no início da linha
                    $ingrediente_limpo = ltrim(trim($ingrediente), '- ');
                    if (!empty($ingrediente_limpo)) {
                        echo '<li>' . htmlspecialchars($ingrediente_limpo) . '</li>';
                    }
                }
                ?>
                </ul>
            </div>
            
            <div class="preparo">
                <h3>Modo de Preparo</h3>
                <?php
                // --- NOVA LÓGICA INTELIGENTE PARA MODO DE PREPARO ---
                $texto_preparo = $receita['preparo'];
                $texto_normalizado_preparo = str_replace(["\r\n", "\r"], "\n", $texto_preparo);
                $linhas_preparo = explode("\n", $texto_normalizado_preparo);
                
                $lista_aberta = false; // Controla se a tag <ol> está aberta

                foreach ($linhas_preparo as $linha) {
                    $linha_trim = trim($linha);
                    if (empty($linha_trim)) continue;

                    // Verifica se a linha termina com ':' para identificá-la como um título
                    if (substr($linha_trim, -1) === ':') {
                        if ($lista_aberta) {
                            echo '</ol>'; // Fecha a lista de passos anterior
                            $lista_aberta = false;
                        }
                        // Usa a tag H4 para criar um subtítulo para a seção
                        echo '<h4 class="preparo-secao-titulo">' . htmlspecialchars($linha_trim) . '</h4>';
                    } else {
                        if (!$lista_aberta) {
                            echo '<ol class="preparo-lista">'; // Abre uma nova lista de passos
                            $lista_aberta = true;
                        }
                        // Formata texto entre **asteriscos** para destaque
                        $passo_formatado = preg_replace('/\*\*(.*?)\*\*/', '<span class="destaque">$1</span>', htmlspecialchars($linha_trim));
                        echo '<li>' . $passo_formatado . '</li>';
                    }
                }

                if ($lista_aberta) {
                    echo '</ol>'; // Fecha a última lista se ela ainda estiver aberta
                }
                ?>
            </div>
        </div>

        <?php if (!empty($receita['info_adicional'])): ?>
        <div class="info-adicional" style="margin-top: 2rem;">
            <h3>Informações Adicionais</h3>
            <p><?php echo nl2br(htmlspecialchars($receita['info_adicional'])); ?></p>
        </div>
        <?php endif; ?>
    </div>
<?php
} else {
    echo "<div class='container'><h2>Receita não encontrada</h2><p>A receita que você está procurando não existe.</p></div>";
}
$stmt->close();
$conn->close();

// Adicionando um pequeno estilo para o novo título de seção do modo de preparo
echo '<style>
.preparo-secao-titulo {
    font-family: var(--font-body);
    font-weight: 600;
    font-size: 1.1rem;
    color: var(--dark-text);
    margin-top: 2rem;
    margin-bottom: 1rem;
    padding-bottom: 0;
    border-bottom: none;
}
</style>';

require_once('../includes/footer.php');
?>