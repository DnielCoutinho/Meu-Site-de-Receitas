<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /coutopasta/paginas/usuarios/login.php");
    exit();
}

$mensagem = '';
$receita = null;
$receita_id = null;

// Mensagem de sucesso vinda do redirecionamento
if (isset($_GET['status']) && $_GET['status'] == 'sucesso') {
    $mensagem = "<p style='color:green;'>Receita atualizada com sucesso!</p>";
}

// Busca dados para os dropdowns
$paises_result = $conn->query("SELECT id, nome FROM paises ORDER BY nome");
$tipos_refeicao_result = $conn->query("SELECT id, nome FROM tipos_refeicao ORDER BY nome");
$categorias_result = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");

// Pega o ID da receita da URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $receita_id = intval($_GET['id']);
}

// Processa o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $receita_id = intval($_POST['receita_id']);
    $nome = $_POST['nome'];
    $pais_id = $_POST['pais_id'];
    $tipo_refeicao_id = $_POST['tipo_refeicao_id'];
    $categoria_id = $_POST['categoria_id'];
    $ingredientes = $_POST['ingredientes'];
    $preparo = $_POST['preparo'];
    $info_adicional = isset($_POST['info_adicional']) ? $_POST['info_adicional'] : '';
    $foto_url = isset($_POST['foto_url']) ? trim($_POST['foto_url']) : '';
    
    // Busca os dados atuais da foto para usar como padrão
    $stmt_foto_atual = $conn->prepare("SELECT foto FROM receitas WHERE id = ?");
    $stmt_foto_atual->bind_param("i", $receita_id);
    $stmt_foto_atual->execute();
    $foto_atual = $stmt_foto_atual->get_result()->fetch_assoc()['foto'];
    $stmt_foto_atual->close();

    $foto_final = $foto_atual; // Começa com o valor antigo

    $upload_dir = '../../uploads/receitas/';

    // Lógica inteligente para fotos
    if (preg_match('/^data:image\/(\w+);base64,/', $foto_url, $type)) {
        $data = substr($foto_url, strpos($foto_url, ',') + 1);
        $type = strtolower($type[1]);
        if (in_array($type, ['jpg', 'jpeg', 'gif', 'png'])) {
            $data = base64_decode($data);
            $nome_foto_unico = uniqid() . '.' . $type;
            if (file_put_contents($upload_dir . $nome_foto_unico, $data)) {
                if (!empty($foto_atual) && !filter_var($foto_atual, FILTER_VALIDATE_URL) && file_exists($upload_dir . $foto_atual)) {
                    unlink($upload_dir . $foto_atual);
                }
                $foto_final = $nome_foto_unico;
            }
        }
    } else if (!empty($foto_url) && filter_var($foto_url, FILTER_VALIDATE_URL)) {
        $foto_final = $foto_url;
    } else if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $nome_arquivo = basename($_FILES['foto']['name']);
        $nome_foto_unico = uniqid() . '-' . preg_replace('/[^A-Za-z0-9\.\-]/', '_', $nome_arquivo);
        if (move_uploaded_file($_FILES['foto']['tmp_name'], $upload_dir . $nome_foto_unico)) {
            if (!empty($foto_atual) && !filter_var($foto_atual, FILTER_VALIDATE_URL) && file_exists($upload_dir . $foto_atual)) {
                unlink($upload_dir . $foto_atual);
            }
            $foto_final = $nome_foto_unico;
        }
    }

    $sql_update = "UPDATE receitas SET nome = ?, pais_id = ?, tipo_refeicao_id = ?, categoria_id = ?, ingredientes = ?, preparo = ?, info_adicional = ?, foto = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("siiissssi", $nome, $pais_id, $tipo_refeicao_id, $categoria_id, $ingredientes, $preparo, $info_adicional, $foto_final, $receita_id);

    if ($stmt_update->execute()) {
        header("Location: editar_receita.php?id=" . $receita_id . "&status=sucesso");
        exit();
    } else {
        $mensagem = "<p style='color:red;'>Erro ao atualizar receita: " . $stmt_update->error . "</p>";
    }
    $stmt_update->close();
}

// Busca os dados da receita para exibir no formulário
if ($receita_id) {
    $stmt_select = $conn->prepare("SELECT * FROM receitas WHERE id = ?");
    $stmt_select->bind_param("i", $receita_id);
    $stmt_select->execute();
    $result_select = $stmt_select->get_result();
    if ($result_select->num_rows > 0) {
        $receita = $result_select->fetch_assoc();
    } else {
        $mensagem = "<p style='color:red;'>Receita não encontrada.</p>";
    }
    $stmt_select->close();
}
?>

<main class="container">
    <?php if ($receita): ?>
        <div class="form-container">
            <h2>Editar Receita</h2>
            <p style="text-align: center; margin-top: -1rem; margin-bottom: 2rem; color: var(--grey-text);">"<?php echo htmlspecialchars($receita['nome']); ?>"</p>

            <?php if(!empty($mensagem)) echo "<div style='text-align:center; margin-bottom:1rem;'>$mensagem</div>"; ?>

            <form method="POST" action="editar_receita.php?id=<?php echo $receita_id; ?>" enctype="multipart/form-data">
                <input type="hidden" name="receita_id" value="<?php echo $receita_id; ?>">
                
                <div class="form-group">
                    <label for="nome">Nome da Receita:</label>
                    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($receita['nome']); ?>" required>
                </div>
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="pais_id">País:</label>
                        <select name="pais_id" id="pais_id" required>
                            <?php $paises_result->data_seek(0); while($pais = $paises_result->fetch_assoc()): ?>
                                <option value="<?php echo $pais['id']; ?>" <?php echo ($receita['pais_id'] == $pais['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($pais['nome']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="tipo_refeicao_id">Tipo de Refeição:</label>
                        <select name="tipo_refeicao_id" id="tipo_refeicao_id" required>
                            <?php $tipos_refeicao_result->data_seek(0); while($tipo = $tipos_refeicao_result->fetch_assoc()): ?>
                                <option value="<?php echo $tipo['id']; ?>" <?php echo ($receita['tipo_refeicao_id'] == $tipo['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($tipo['nome']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="categoria_id">Categoria:</label>
                        <select name="categoria_id" id="categoria_id" required>
                            <?php $categorias_result->data_seek(0); while($cat = $categorias_result->fetch_assoc()): ?>
                                <option value="<?php echo $cat['id']; ?>" <?php echo ($receita['categoria_id'] == $cat['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat['nome']); ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <hr class="form-separator">

                <div class="form-group">
                    <label for="ingredientes">Ingredientes (um por linha):</label>
                    <textarea name="ingredientes" id="ingredientes" rows="10" required><?php echo htmlspecialchars($receita['ingredientes']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="preparo">Modo de Preparo (um passo por linha):</label>
                    <textarea name="preparo" id="preparo" rows="15" required><?php echo htmlspecialchars($receita['preparo']); ?></textarea>
                </div>
                <div class="form-group">
                    <label for="info_adicional">Informações Adicionais / Dicas:</label>
                    <textarea id="info_adicional" name="info_adicional" rows="5"><?php echo htmlspecialchars($receita['info_adicional'] ?? ''); ?></textarea>
                </div>

                <hr class="form-separator">

                <div class="form-group">
                    <label>Foto da Receita</label>
                    <p style="font-size: 0.9em; color: var(--grey-text); margin-top: -0.5rem; margin-bottom: 1rem;">A foto atual é exibida abaixo. Para alterar, cole uma nova URL ou envie um arquivo.</p>
                    <img src="<?php echo get_foto_src($receita['foto']); ?>" alt="Foto da Receita" class="foto-preview">
                    
                    <label for="foto_url" style="margin-top: 1rem;">Opção 1: Colar URL ou Imagem (Data URI)</label>
                    <input type="text" id="foto_url" name="foto_url" placeholder="Cole uma URL ou arraste uma imagem aqui" value="<?php echo filter_var($receita['foto'], FILTER_VALIDATE_URL) ? htmlspecialchars($receita['foto']) : ''; ?>">

                    <label for="foto" style="margin-top: 1rem;">Opção 2: Enviar um Arquivo</label>
                    <input type="file" id="foto" name="foto" accept="image/*" class="input-file">
                </div>

                <input type="submit" value="Atualizar Receita" class="btn" style="width: 100%; padding: 1rem;">
            </form>
        </div>
    <?php else: ?>
        <div class="form-container">
             <?php echo $mensagem ?: "<p>Não foi possível carregar os dados da receita para edição.</p>"; ?>
        </div>
    <?php endif; ?>
</main>

<?php 
$conn->close();
require_once('../includes/footer.php'); 
?>