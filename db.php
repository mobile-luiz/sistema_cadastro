<?php
$host = '127.0.0.1'; // ou 'localhost'
$dbname = 'sistema_cadastro'; // nome do banco de dados
$username = 'root'; // usuário do MySQL
$password = ''; // senha do MySQL, geralmente vazia no XAMPP

try {
    // Conexão com o banco de dados
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    // Configura para gerar exceções em caso de erro
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro ao conectar ao banco de dados: " . $e->getMessage());
}
?>
