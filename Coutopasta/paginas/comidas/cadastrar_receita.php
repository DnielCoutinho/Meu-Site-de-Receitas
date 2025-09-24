<?php
require_once('../includes/header.php');
require_once('../../config.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: /coutopasta/paginas/usuarios/login.php");
    exit();
}

$mensagem = '';
$paises_result = $conn->query("SELECT id, nome FROM paises ORDER BY nome");
$tipos_refeicao_result = $conn->query("SELECT id, nome FROM tipos_refeicao ORDER BY nome");
$categorias_result = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']);
    $pais_id = $_POST['pais_id'];
    $tipo_refeicao_id = $_POST['tipo_refeicao_id'];
    $categoria_id = $_POST['categoria_id'];
    $ingredientes = $_POST['ingredientes'];
    $preparo = $_POST['preparo'];
    $info_adicional = isset($_POST['info_adicional']) ? $_POST['info_adicional'] : null;
    $usuario_id = $_SESSION['usuario_id'];
    $foto_final = null; // Usará URL ou nome de arquivo

    $foto_url = isset($_POST['foto_url']) ? trim($_POST['foto_url']) : '';

    $sql_check = "SELECT id FROM receitas WHERE nome = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $nome);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $mensagem = "<p style='color:red;'>Erro: Já existe uma receita cadastrada com este nome.</p>";
    } else {
        if (!empty($foto_url) && filter_var($foto_url, FILTER_VALIDATE_URL)) {
            $foto_final = $foto_url;
        } elseif (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = '../../uploads/receitas/';
            $nome_arquivo = basename($_FILES['foto']['name']);
            $nome_foto_unico = uniqid() . '-' . preg_replace('/[^A-Za-z0-9\.\-]/', '_', $nome_arquivo);
            $caminho_foto = $upload_dir . $nome_foto_unico;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto)) {
                $foto_final = $nome_foto_unico;
            } else {
                $mensagem = "<p style='color:red;'>Erro ao fazer upload da foto.</p>";
            }
        }

        if (empty($mensagem)) {
            $sql = "INSERT INTO receitas (nome, pais_id, tipo_refeicao_id, categoria_id, ingredientes, preparo, info_adicional, usuario_id, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("siiisssis", $nome, $pais_id, $tipo_refeicao_id, $categoria_id, $ingredientes, $preparo, $info_adicional, $usuario_id, $foto_final);

            if ($stmt->execute()) {
                $mensagem = "<p style='color:green;'>Receita cadastrada com sucesso!</p>";
            } else {
                $mensagem = "<p style='color:red;'>Erro ao cadastrar receita: " . $stmt->error . "</p>";
            }
            $stmt->close();
        }
    }
    $stmt_check->close();
}
?>

<div class="container">
    <div class="form-container">
        <h2>Cadastrar Nova Receita</h2>
        <p style="text-align: center; margin-top: -1rem; margin-bottom: 2rem; color: var(--grey-text);">Compartilhe seus sabores com o mundo.</p>

        <?php if(!empty($mensagem)) echo "<div style='text-align:center; margin-bottom:1rem;'>$mensagem</div>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome da Receita:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="pais_id">País:</label>
                    <select name="pais_id" id="pais_id" required>
                        <option value="">Selecione um país</option>
                        <?php $paises_result->data_seek(0); while($pais = $paises_result->fetch_assoc()): ?>
                            <option value="<?php echo $pais['id']; ?>"><?php echo htmlspecialchars($pais['nome']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipo_refeicao_id">Tipo de Refeição:</label>
                    <select name="tipo_refeicao_id" id="tipo_refeicao_id" required>
                        <option value="">Selecione um tipo</option>
                        <?php $tipos_refeicao_result->data_seek(0); while($tipo = $tipos_refeicao_result->fetch_assoc()): ?>
                            <option value="<?php echo $tipo['id']; ?>"><?php echo htmlspecialchars($tipo['nome']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="categoria_id">Categoria:</label>
                    <select name="categoria_id" id="categoria_id" required>
                        <option value="">Selecione uma categoria</option>
                        <?php $categorias_result->data_seek(0); while($cat = $categorias_result->fetch_assoc()): ?>
                            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nome']); ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <hr class="form-separator">

            <div class="form-group">
                <label for="ingredientes">Ingredientes (um por linha):</label>
                <textarea name="ingredientes" id="ingredientes" rows="10" required></textarea>
            </div>
            <div class="form-group">
                <label for="preparo">Modo de Preparo (um passo por linha):</label>
                <textarea name="preparo" id="preparo" rows="15" required></textarea>
            </div>
            <div class="form-group">
                <label for="info_adicional">Informações Adicionais / Dicas:</label>
                <textarea id="info_adicional" name="info_adicional" rows="5"></textarea>
            </div>

            <hr class="form-separator">

            <div class="form-group">
                <label>Foto da Receita</label>
                <p style="font-size: 0.9em; color: var(--grey-text); margin-top: -0.5rem; margin-bottom: 1rem;">Cole a URL de uma imagem ou envie um arquivo do seu computador.</p>
                
                <label for="foto_url" style="margin-top: 1rem;">Opção 1: Colar URL da Imagem</label>
                <input type="text" id="foto_url" name="foto_url" placeholder="https://exemplo.com/imagem.jpg">

                <label for="foto" style="margin-top: 1rem;">Opção 2: Enviar um Arquivo</label>
                <input type="file" id="foto" name="foto" accept="image/*" class="input-file">
            </div>

            <input type="submit" value="Cadastrar Receita" class="btn" style="width: 100%; padding: 1rem;">
        </form>
    </div>
</div>

<?php 
$conn->close();
require_once('../includes/footer.php'); 
?>