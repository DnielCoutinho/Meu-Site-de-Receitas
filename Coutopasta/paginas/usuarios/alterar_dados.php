<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}
$usuario_id = $_SESSION['usuario_id'];
$mensagem = '';

// Busca os dados atuais do usuário para preencher o formulário
$sql_select = "SELECT nome, email FROM usuarios WHERE id = ?";
$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $usuario_id);
$stmt_select->execute();
$result = $stmt_select->get_result();

if ($result->num_rows > 0) {
    $usuario = $result->fetch_assoc();
    $nome_atual = $usuario['nome'];
    $email_atual = $usuario['email'];
} else {
    echo "<p>Usuário não encontrado.</p>";
    exit();
}
$stmt_select->close();

// Processa o formulário quando enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $novo_nome = $_POST['nome'];
    $novo_email = $_POST['email'];

    $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $novo_nome, $novo_email, $usuario_id);

    if ($stmt->execute()) {
        $mensagem = "<p style='color:green;'>Dados alterados com sucesso!</p>";
        $_SESSION['usuario_nome'] = $novo_nome; // Atualiza o nome na sessão
        // Atualiza as variáveis para o formulário refletir a mudança imediatamente
        $nome_atual = $novo_nome;
        $email_atual = $novo_email;
    } else {
        $mensagem = "<p style='color:red;'>Erro ao alterar dados: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

$conn->close();
?>

<h2>Alterar Dados Cadastrais</h2>
<?php echo $mensagem; ?>
<form method="POST" action="alterar_dados.php">
    <label for="nome">Nome:</label><br>
    <input type="text" id="nome" name="nome" value="<?php echo htmlspecialchars($nome_atual); ?>" required><br><br>

    <label for="email">Email:</label><br>
    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email_atual); ?>" required><br><br>

    <input type="submit" value="Salvar Alterações">
</form>

<?php require_once('../includes/footer.php'); ?>
