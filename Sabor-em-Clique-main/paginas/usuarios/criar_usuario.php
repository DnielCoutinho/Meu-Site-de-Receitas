<?php
session_start();
require_once('../../config.php');

$mensagem = '';
if (isset($_SESSION['usuario_id'])) {
    header("Location: " . BASE_URL . "/");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha_post = $_POST['senha'];

    $sql_check = "SELECT id FROM usuarios WHERE email = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $email);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        $mensagem = "<p style='color:red;'>Este email já está cadastrado. Por favor, use outro ou faça login.</p>";
    } else {
        $senha_hash = password_hash($senha_post, PASSWORD_DEFAULT);
        $sql_insert = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sss", $nome, $email, $senha_hash);

        if ($stmt_insert->execute()) {
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
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Criar Conta - Sabor em Clique</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/css/style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons" rel="stylesheet">
</head>
<body>
    <header class="main-header">
        <div class="container header-container">
            <a href="<?php echo BASE_URL; ?>/paginas/usuarios/login.php" class="logo">Sabor em Clique</a>
            
            <div class="header-actions">
                <div class="user-actions">
                    <span>Criar nova conta</span>
                </div>
            </div>
        </div>
    </header>

    <main>

<div class="container">
    <div class="form-container">
        <h2>Criar Novo Usuário</h2>
        <?php if(!empty($mensagem)) echo "<div style='text-align:center; margin-bottom:1rem;'>$mensagem</div>"; ?>

        <form method="POST">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <input type="submit" value="Criar Usuário" class="btn" style="width: 100%;">
            </div>
        </form>
         <div style="text-align: center; margin-top: 20px;">
            <p>Já tem uma conta? <a href="login.php">Faça o login</a>.</p>
        </div>
    </div>
</div>

</main>
</body>
</html>