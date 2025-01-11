<?php
include('db.php');

// Buscar todos os usuários cadastrados
$stmt = $pdo->prepare("SELECT * FROM usuarios");
$stmt->execute();
$usuarios = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listagem de Usuários</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Usuários Cadastrados</h1>
    <table>
        <thead>
            <tr>
                <th>Nome</th>
                <th>E-mail</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
            <tr>
                <td><?= htmlspecialchars($usuario['nome']) ?></td>
                <td><?= htmlspecialchars($usuario['email']) ?></td>
                <td>
                    <a href="editar.php?id=<?= $usuario['id'] ?>">Editar</a> | 
                    <a href="excluir.php?id=<?= $usuario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
