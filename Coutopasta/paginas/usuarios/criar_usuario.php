<?php
require_once('../includes/header.php');
require_once('../../config.php');

// Se o usuário já estiver logado, redireciona para a página inicial
if (isset($_SESSION['usuario_id'])) {
    header("Location: /coutopasta/");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $nome, $email, $senha);

    if ($stmt->execute()) {
        // Redireciona para a página de login após o sucesso
        header("Location: login.php?status=sucesso");
        exit();
    } else {
        echo "<p>Erro ao criar usuário: " . $stmt->error . "</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<div class="form-container">
    <h2>Criar Novo Usuário</h2>
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
