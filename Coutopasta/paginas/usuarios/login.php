<?php
require_once('../includes/header.php');
require_once('../../config.php');
 
// Se o usuário já estiver logado, redireciona para a página inicial
if (isset($_SESSION['usuario_id'])) {
    header("Location: /coutopasta/");
    exit();
}

$mensagem = '';
if (isset($_GET['status']) && $_GET['status'] == 'sucesso') {
    $mensagem = "<p style='color:green;'>Usuário criado com sucesso! Faça o login.</p>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nome, senha, is_admin FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        if (password_verify($senha, $usuario['senha'])) {
                        $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nome'] = $usuario['nome'];
            $_SESSION['is_admin'] = $usuario['is_admin'];
            header("Location: /coutopasta/"); // Redireciona para a página principal
            exit();
        } else {
            $mensagem = "<p style='color:red;'>Email ou senha incorretos.</p>";
        }
    } else {
        $mensagem = "<p style='color:red;'>Email ou senha incorretos.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<div class="form-container">
    <h2>Login</h2>
    <?php echo $mensagem; ?>
    <form method="POST" class="form-validate" novalidate>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" data-validate="required email">
        </div>

        <div class="form-group">
            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" class="form-control" data-validate="required">
        </div>

        <div class="form-group">
            <input type="submit" value="Entrar" class="btn">
        </div>
    </form>
    <div style="text-align: center; margin-top: 20px;">
        <p>Não tem uma conta? <a href="criar_usuario.php">Crie uma aqui</a>.</p>
        <p><a href="recuperar_senha.php">Esqueceu sua senha?</a></p>
    </div>
</div>

<?php require_once('../includes/footer.php'); ?>
