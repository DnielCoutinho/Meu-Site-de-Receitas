<?php
require_once('../includes/header.php');
require_once('../../config.php');

// 1. Verificação de Segurança e Permissões
if (!isset($_SESSION['usuario_id'])) {
    header("Location: /coutopasta/paginas/usuarios/login.php");
    exit();
}

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo "<h2>Erro</h2><p>ID da receita inválido ou não fornecido.</p>";
    require_once('../includes/footer.php');
    exit();
}

$receita_id = intval($_GET['id']);

// 2. Buscar informações da receita (foto e dono)
$stmt = $conn->prepare("SELECT foto, usuario_id FROM receitas WHERE id = ?");
$stmt->bind_param("i", $receita_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "<h2>Erro</h2><p>Receita não encontrada.</p>";
    $stmt->close();
    require_once('../includes/footer.php');
    exit();
}

$receita = $result->fetch_assoc();
$stmt->close();

// Verifica se o usuário tem permissão para excluir (é o dono ou é admin)
$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
if ($receita['usuario_id'] != $_SESSION['usuario_id'] && !$is_admin) {
    echo "<h2>Acesso Negado</h2><p>Você não tem permissão para excluir esta receita.</p>";
    require_once('../includes/footer.php');
    exit();
}

// 3. Excluir a receita do Banco de Dados
$stmt_delete = $conn->prepare("DELETE FROM receitas WHERE id = ?");
$stmt_delete->bind_param("i", $receita_id);

if ($stmt_delete->execute()) {
    // 4. Se a exclusão do BD funcionar, apagar o arquivo da foto
    if (!empty($receita['foto'])) {
        $caminho_foto = '../../uploads/receitas/' . $receita['foto'];
        if (file_exists($caminho_foto)) {
            unlink($caminho_foto); // Apaga o arquivo do servidor
        }
    }

    // 5. Redirecionar para a lista de comidas com mensagem de sucesso
    // Usaremos a sessão para passar a mensagem
    $_SESSION['mensagem_sucesso'] = "Receita excluída com sucesso!";
    header("Location: /coutopasta/paginas/comidas/listar_comidas.php");
    exit();

} else {
    echo "<h2>Erro</h2><p>Ocorreu um erro ao tentar excluir a receita. Por favor, tente novamente.</p>";
}

$stmt_delete->close();
$conn->close();

require_once('../includes/footer.php');
?>
