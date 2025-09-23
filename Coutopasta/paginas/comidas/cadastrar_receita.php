<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /coutopasta/paginas/usuarios/login.php");
    exit();
}

$mensagem = '';

// Busca dados para os dropdowns
$paises_result = $conn->query("SELECT id, nome FROM paises ORDER BY nome");
$tipos_refeicao_result = $conn->query("SELECT id, nome FROM tipos_refeicao ORDER BY nome");
$categorias_result = $conn->query("SELECT id, nome FROM categorias ORDER BY nome");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST['nome']); // Usa trim() para remover espaços em branco no início e fim
    $pais_id = $_POST['pais_id'];
    $tipo_refeicao_id = $_POST['tipo_refeicao_id'];
    $categoria_id = $_POST['categoria_id'];
    $ingredientes = $_POST['ingredientes'];
    $preparo = $_POST['preparo'];
    $info_adicional = isset($_POST['info_adicional']) ? $_POST['info_adicional'] : null;
    $usuario_id = $_SESSION['usuario_id'];
    $foto_nome = null;

    // *** INÍCIO DA ALTERAÇÃO ***
    // 1. Verifica se já existe uma receita com o mesmo nome
    $sql_check = "SELECT id FROM receitas WHERE nome = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $nome);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $mensagem = "<p style='color:red;'>Erro: Já existe uma receita cadastrada com este nome. Por favor, escolha outro nome.</p>";
    } else {
        // 2. Se o nome não existir, o código para cadastrar a receita continua aqui dentro
        // *** FIM DA ALTERAÇÃO (APENAS A ABERTURA DO ELSE) ***

        // Lógica para upload da foto
        if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
            // Diretório de upload relativo ao script atual
            $upload_dir = '../../uploads/receitas/';
            
            // Garante que o nome do arquivo é seguro
            $nome_arquivo = basename($_FILES['foto']['name']);
            
            // Cria um nome único para evitar sobreposições e problemas com nomes de arquivo
            $nome_foto_unico = uniqid() . '-' . preg_replace('/[^A-Za-z0-9\.\-]/', '_', $nome_arquivo);
            
            $caminho_foto = $upload_dir . $nome_foto_unico;

            // Move o arquivo para o diretório de uploads
            if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminho_foto)) {
                $foto_nome = $nome_foto_unico; // Salva apenas o nome do arquivo no banco
            } else {
                $mensagem = "<p style='color:red;'>Erro ao fazer upload da foto.</p>";
            }
        }

        if (empty($mensagem) && (empty($nome) || empty($pais_id) || empty($tipo_refeicao_id) || empty($categoria_id) || empty($ingredientes) || empty($preparo))) {
            $mensagem = "<p style='color:red;'>Todos os campos, exceto a foto, são obrigatórios.</p>";
        } elseif (empty($mensagem)) {
            $sql = "INSERT INTO receitas (nome, pais_id, tipo_refeicao_id, categoria_id, ingredientes, preparo, info_adicional, usuario_id, foto) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            
            $stmt->bind_param("siiisssis", $nome, $pais_id, $tipo_refeicao_id, $categoria_id, $ingredientes, $preparo, $info_adicional, $usuario_id, $foto_nome);

            if ($stmt->execute()) {
                $mensagem = "<p style='color:green;'>Receita cadastrada com sucesso!</p>";
            } else {
                $mensagem = "<p style='color:red;'>Erro ao cadastrar receita: " . $stmt->error . "</p>";
            }
            $stmt->close();
        }
    
    // *** INÍCIO DA ALTERAÇÃO ***
    // 3. Fecha o 'else' e o 'stmt_check'
    }
    $stmt_check->close();
    // *** FIM DA ALTERAÇÃO ***
}
$conn->close();
?>

<h2>Cadastrar Nova Receita</h2>
<?php echo $mensagem; ?>
<form method="POST" enctype="multipart/form-data">
    <label for="nome">Nome da Receita:</label>
    <input type="text" id="nome" name="nome" required>

    <label for="pais_id">País:</label>
    <select name="pais_id" id="pais_id" required>
        <option value="">Selecione um país</option>
        <?php while($pais = $paises_result->fetch_assoc()): ?>
            <option value="<?php echo $pais['id']; ?>"><?php echo htmlspecialchars($pais['nome']); ?></option>
        <?php endwhile; ?>
    </select>

    <label for="tipo_refeicao_id">Tipo de Refeição:</label>
    <select name="tipo_refeicao_id" id="tipo_refeicao_id" required>
        <option value="">Selecione um tipo de refeição</option>
        <?php while($tipo = $tipos_refeicao_result->fetch_assoc()): ?>
            <option value="<?php echo $tipo['id']; ?>"><?php echo htmlspecialchars($tipo['nome']); ?></option>
        <?php endwhile; ?>
    </select>

    <label for="categoria_id">Categoria:</label>
    <select name="categoria_id" id="categoria_id" required>
        <option value="">Selecione uma categoria</option>
        <?php while($cat = $categorias_result->fetch_assoc()): ?>
            <option value="<?php echo $cat['id']; ?>"><?php echo htmlspecialchars($cat['nome']); ?></option>
        <?php endwhile; ?>
    </select>

    <label for="ingredientes">Ingredientes:</label>
    <textarea name="ingredientes" id="ingredientes" rows="8" placeholder="Liste os ingredientes, um por linha." required></textarea>

    <label for="preparo">Modo de Preparo:</label>
    <textarea name="preparo" id="preparo" rows="12" placeholder="Descreva o passo a passo da receita." required></textarea>

    <label for="info_adicional">Informações adicionais / Dicas (opcional):</label>
    <textarea id="info_adicional" name="info_adicional" rows="5" placeholder="Dicas, curiosidades ou informações extras sobre a receita..."></textarea>

    <label for="foto">Foto da Receita:</label>
    <input type="file" id="foto" name="foto" accept="image/*">

    <input type="submit" value="Cadastrar Receita">
</form>

<style>
    select, textarea {
        width: 100%; padding: 12px; margin-bottom: 15px; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins', sans-serif;
    }
</style>

<?php require_once('../includes/footer.php'); ?>