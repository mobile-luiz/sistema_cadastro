<?php
include('db.php');

// Verifica se o ID foi passado via GET e se é válido
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if (!$id) {
    die('ID do usuário não fornecido ou inválido.');
}

try {
    // Verifica se o usuário existe no banco de dados
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
    $stmt->execute([$id]);
    $usuario = $stmt->fetch();

    if (!$usuario) {
        die('Usuário não encontrado.');
    }

    // Se o formulário de confirmação foi enviado e a opção for "Sim", exclui o usuário
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['confirmar']) && $_POST['confirmar'] == 'sim') {
            // Excluir o usuário
            $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);

            // Exibe uma mensagem de sucesso após a exclusão
            echo '<p>Usuário excluído com sucesso!</p>';
            echo '<p><a href="listagem.php">Voltar para a lista de usuários</a></p>';
            exit();
        } else {
            // Se a opção for "Não", retorna para a listagem de usuários
            header('Location: listagem.php');
            exit();
        }
    }
} catch (PDOException $e) {
    // Trata erros do banco de dados
    die('Erro ao excluir o usuário: ' . htmlspecialchars($e->getMessage()));
}
?>

<!-- Formulário de Confirmação -->
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Exclusão</title>
</head>
<body>
    <h1>Confirmar Exclusão</h1>
    <p>Tem certeza de que deseja excluir o usuário <strong><?php echo htmlspecialchars($usuario['nome']); ?></strong>?</p>
    
    <form method="POST">
        <button type="submit" name="confirmar" value="sim">Sim, excluir</button>
        <button type="submit" name="confirmar" value="nao">Não, voltar</button>
    </form>
</body>
</html>
