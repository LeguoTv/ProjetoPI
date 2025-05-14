<?php

// Conectar ao banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sistema_login";

// cadastro.php
// Iniciar sessão
session_start();

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "sistema_login");

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter e sanitizar os dados
    $nome = trim($_POST['nome']);
    $email = trim($_POST['email']);
    $senha = $_POST['senha'];
    $data_NSC = trim($_POST['data_nascimento']);
    $telefone = $_POST['telefone'];
    $cidade = trim($_POST['cidade']);
    $estado = trim($_POST['estado']);
    $endereco = trim($_POST['endereco']);

    // Validar e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: cadastrar.php?error=E-mail inválido.");
        exit();
    }

    // Verificar se o e-mail já está cadastrado usando prepared statements
    $stmt = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // E-mail já cadastrado
        header("Location: cadastrar.php?error=Este e-mail já está cadastrado.");
        $stmt->close();
        $conn->close();
        exit();
    }
    $stmt->close();

    // Criptografar a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir o novo usuário usando prepared statements
    $stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha, data_NSC, telefone, cidade, estado, endereco) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssss", $nome, $email, $senha_hash, $data_NSC, $telefone, $cidade, $estado, $endereco);

    if ($stmt->execute()) {
    $_SESSION['success'] = "Usuário cadastrado com sucesso!";
} else {
    $_SESSION['error'] = "Erro ao cadastrar usuário.";
}
header("Location: cadastrar.php");
exit();
    $stmt->close();
}

$conn->close();
?>

