<?php
require_once('../includes/header.php');
require_once('../../config.php');

$mensagem = '';

// Se o usuário já estiver logado, redireciona para a página inicial
if (isset($_SESSION['usuario_id'])) {
    header("Location: /coutopasta/");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha_post = $_POST['senha'];

    // 1. Verificar se o email já existe
    $sql_check = "SELECT id FROM usuarios WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $mensagem = "<p style='color:red;'>Este email já está cadastrado. Por favor, use outro ou faça login.</p>";
    } else {
        // 2. Se não existir, prosseguir com a criação
        $senha_hash = password_hash($senha_post, PASSWORD_DEFAULT);

        $sql_insert = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sss", $nome, $email, $senha_hash);

        if ($stmt_insert->execute()) {
            // Redireciona para a página de login após o sucesso
            header("Location: login.php?status=sucesso");
            exit();
        } else {
            $mensagem = "<p style='color:red;'>Erro ao criar usuário: " . $stmt_insert->error . "</p>";
        }
        $stmt_insert->close();
    }
    $stmt_check->close();
    $conn->close();
}
?>

<div class="form-container">
    <h2>Criar Novo Usuário</h2>
    <?php if(!empty($mensagem)) echo $mensagem; ?>
    <form method="POST" class="form-validate" novalidate>
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" class="form-control" data-validate="required">
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" class="form-control" data-validate="required email">
        </div>

        <div class="form-group">
            <label for="senha">Senha (mínimo 6 caracteres):</label>
            <input type="password" id="senha" name="senha" class="form-control" data-validate="required password">
        </div>
        
        <div class="form-group">
            <label for="senha_confirm">Confirme a Senha:</label>
            <input type="password" id="senha_confirm" name="senha_confirm" class="form-control" data-validate="required match" data-match="#senha">
        </div>

        <div class="form-group">
            <input type="submit" value="Criar Usuário" class="btn">
        </div>
    </form>
</div>

<?php require_once('../includes/footer.php'); ?>