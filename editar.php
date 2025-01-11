<?php
include('db.php');

// Verifica se o ID foi passado via GET
define('ERROR_MESSAGE', 'ID do usuário não fornecido.');
$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
if (!$id) {
    die(ERROR_MESSAGE);
}

// Buscar o usuário com o ID informado
$stmt = $pdo->prepare("SELECT * FROM usuarios WHERE id = ?");
$stmt->execute([$id]);
$usuario = $stmt->fetch();

if (!$usuario) {
    die('Usuário não encontrado.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Coleta os dados do formulário
    $nome = trim($_POST['nome']);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $senha = trim($_POST['senha']);

    // Validação
    if (empty($nome) || !$email || empty($senha)) {
        echo "Todos os campos são obrigatórios e o e-mail deve ser válido!";
    } else {
        // Hash da nova senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Atualizar os dados do usuário
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?");
        if ($stmt->execute([$nome, $email, $senhaHash, $id])) {
            echo "Usuário atualizado com sucesso!";
        } else {
            echo "Erro ao atualizar usuário.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Editar Usuário</h1>
    <form action="editar.php?id=<?= htmlspecialchars($usuario['id']) ?>" method="POST">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" required>

        <button type="submit">Atualizar</button>
    </form>
</body>
</html>
