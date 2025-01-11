# Sistema de Cadastro de Usuários

Este projeto é um sistema simples de cadastro de usuários, onde é possível adicionar, listar, editar e excluir usuários. O sistema utiliza PHP para o backend, MySQL para o banco de dados e HTML/CSS para o frontend.

## Funcionalidades

- **Cadastro de Usuários:** Permite o cadastro de novos usuários com nome, e-mail e senha.
- **Validação de Dados:** Validações de campos obrigatórios e e-mail único.
- **Listagem de Usuários:** Exibe todos os usuários cadastrados em uma tabela com suas informações.
- **Edição e Exclusão de Usuários:** Permite editar e excluir usuários da base de dados.

## Tecnologias Utilizadas

- **PHP:** Para processamento de backend e interação com o banco de dados.
- **MySQL:** Para armazenar os dados dos usuários.
- **HTML/CSS:** Para a construção da interface do usuário.
- **JavaScript (opcional):** Para validação de dados no frontend.

## Pré-requisitos

Antes de rodar o projeto, você precisa ter os seguintes pré-requisitos instalados:

- **PHP:** Versão 7.0 ou superior.
- **MySQL:** Para configurar o banco de dados.
- **Servidor Web (opcional):** Como o XAMPP, WAMP, ou Apache.

## Como Rodar o Projeto

### 1. Configuração do Banco de Dados

Primeiro, crie o banco de dados no MySQL e a tabela de usuários com a seguinte consulta SQL:

```sql
CREATE DATABASE cadastro_usuarios;

USE cadastro_usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    data_cadastro DATETIME NOT NULL
);
