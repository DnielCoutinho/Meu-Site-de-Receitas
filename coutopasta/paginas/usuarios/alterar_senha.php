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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $senha_atual = $_POST['senha_atual'];
    $nova_senha = $_POST['nova_senha'];
    $confirmar_nova_senha = $_POST['confirmar_nova_senha'];

    // Busca a senha atual do usuário
    $sql = "SELECT senha FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        if (password_verify($senha_atual, $usuario['senha'])) {
            // Verifica se a nova senha e a confirmação coincidem
            if ($nova_senha == $confirmar_nova_senha) {
                // Hash da nova senha
                $nova_senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);

                // Atualiza a senha no banco de dados
                $sql = "UPDATE usuarios SET senha = ? WHERE id = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("si", $nova_senha_hash, $usuario_id);

                if ($stmt->execute()) {
                    $mensagem = "<p style='color:green;'>Senha alterada com sucesso!</p>";
                } else {
                    $mensagem = "<p style='color:red;'>Erro ao alterar a senha: " . $stmt->error . "</p>";
                }
            } else {
                $mensagem = "<p style='color:red;'>A nova senha e a confirmação não coincidem.</p>";
            }
        } else {
            $mensagem = "<p style='color:red;'>Senha atual incorreta.</p>";
        }
    } else {
        $mensagem = "<p style='color:red;'>Usuário não encontrado.</p>";
    }
    
    $stmt->close();
    $conn->close();
}
?>

<h2>Alterar Senha</h2>
<form method="POST">
    <?php echo $mensagem; ?>
    <label for="senha_atual">Senha Atual:</label><br>
    <input type="password" id="senha_atual" name="senha_atual" required><br><br>

    <label for="nova_senha">Nova Senha:</label><br>
    <input type="password" id="nova_senha" name="nova_senha" required><br><br>

    <label for="confirmar_nova_senha">Confirmar Nova Senha:</label><br>
    <input type="password" id="confirmar_nova_senha" name="confirmar_nova_senha" required><br><br>

    <input type="submit" value="Alterar Senha">
</form>

<?php require_once('../includes/footer.php'); ?>
