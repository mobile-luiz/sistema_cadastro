<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set('America/Sao_Paulo'); // Configura o fuso horário para o Brasil

include('db.php');  // Conexão com o banco de dados

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Validação
    if (empty($nome) || empty($email) || empty($senha)) {
        echo "Todos os campos são obrigatórios!";
    } else {
        // Hash da senha
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        // Verifica se o e-mail já existe
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $stmt->execute([$email]);
        if ($stmt->rowCount() > 0) {
            echo "E-mail já cadastrado!";
        } else {
            // Insere o novo usuário no banco de dados com a data de cadastro
            $dataCadastro = date('Y-m-d H:i:s'); // Obtém a data e hora atual
            $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha, data_cadastro) VALUES (?, ?, ?, ?)");
            $stmt->execute([$nome, $email, $senhaHash, $dataCadastro]);
            echo "Usuário cadastrado com sucesso!";
        }
    }
}

// Buscar todos os usuários cadastrados
$stmt = $pdo->prepare("SELECT * FROM usuarios");
$stmt->execute();

// Verifique se existem usuários
if ($stmt->rowCount() > 0) {
    $usuarios = $stmt->fetchAll();
    $quantidadeUsuarios = count($usuarios); // Conta a quantidade de usuários
} else {
    $usuarios = [];
    $quantidadeUsuarios = 0; // Se não houver usuários, a quantidade será 0
    echo "Nenhum usuário encontrado.";
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Usuário</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f9;
        }

        h1 {
            color: #333;
        }

        form {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin: 8px 0 4px;
        }

        input[type="text"], input[type="email"], input[type="password"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #45a049;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            color: #333;
        }

        td a {
            color: #3498db;
            text-decoration: none;
        }

        td a:hover {
            text-decoration: underline;
        }

        /* Tabela rolante */
        .tabela-rolante {
            max-height: 300px;
            overflow-y: auto;
        }

        /* Congelar o cabeçalho da tabela */
        th {
            position: sticky;
            top: 0;
            background-color: #f2f2f2;
            color: #333;
            z-index: 1; /* Garante que o cabeçalho fique acima das linhas */
        }
    </style>
</head>
<body>
    <h1>Cadastro de Novo Usuário</h1>
    
    <!-- Formulário de Cadastro -->
    <form action="cadastro.php" method="POST">
        <label for="nome">Nome</label>
        <input type="text" name="nome" id="nome" required>

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" required>

        <label for="senha">Senha</label>
        <input type="password" name="senha" id="senha" required>

        <button type="submit">Cadastrar</button>
    </form>

    <!-- Exibindo a quantidade de usuários cadastrados -->
    <h2>Quantidade de Usuários Cadastrados: <?= $quantidadeUsuarios ?></h2>

    <!-- Exibindo a lista de usuários cadastrados -->
    <?php if (count($usuarios) > 0): ?>
    <div class="tabela-rolante">
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Data de Cadastro</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= htmlspecialchars($usuario['nome']) ?></td>
                    <td><?= htmlspecialchars($usuario['email']) ?></td>
                    <td><?= date('d/m/Y H:i:s', strtotime($usuario['data_cadastro'])) ?></td> <!-- Exibe a data formatada -->
                    <td>
                        <a href="editar.php?id=<?= $usuario['id'] ?>">Editar</a> | 
                        <a href="excluir.php?id=<?= $usuario['id'] ?>" onclick="return confirm('Tem certeza que deseja excluir este usuário?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <p>Não há usuários cadastrados.</p>
    <?php endif; ?>

</body>
</html>
