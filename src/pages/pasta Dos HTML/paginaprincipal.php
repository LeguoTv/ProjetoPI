<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Conecta ao banco
$pdo = new PDO("mysql:host=localhost;dbname=sistema_login", "root", "");
$usuario_id = $_SESSION['usuario_id'];

$stmt = $pdo->prepare("SELECT nome FROM usuarios WHERE id = ?");
$stmt->execute([$usuario_id]);
$nome = $stmt->fetchColumn() ?: "Usuário Desconhecido";
?>

<!DOCTYPE html>
<html lang="pt-br">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página Principal</title>
    <link
      rel="stylesheet"
      href="../../styles/pasta Dos CSS/paginaprincipal.css"
    />

  </head>

  <body>
    <!-- Cabeçalho -->
    <div id="navbar-container"></div>


    <!-- Conteudo do Seja Bem-vindo-->

    <div class="BemVindo">
      <h1>Seja Bem-vindo <span id="h1"><?= htmlspecialchars($nome) ?>!</span></h1>
      <p>Ao Futuro da sua <br><span id="p">Liberdade Financeira</span></p>
    </div>

  <div class="Conteudo">
    <!-- Quadrado para colocar uma imagem -->
     
    <div class="imagem-container">
      <img src="../../assets/Imagens do Site/Captura de tela 2025-04-14 092901.png" alt="Imagem exemplo" />
    </div>
  </div>
    <!-- CHATBOT -->
  
    <div class="ChatWrapper">
      <div class="chatExpandido">
        <div class="chat-box" id="chatbox"></div>
  
        <form id="chat-form">
          <input
            type="text"
            id="messageInput"
            placeholder="Digite sua mensagem..."
            required
          />
          <button type="submit">Enviar</button>
        </form>
      </div>
  
      <div class="ChatIA">
        <img src="https://static.vecteezy.com/system/resources/previews/007/225/199/non_2x/robot-chat-bot-concept-illustration-vector.jpg" alt="Abrir Chat Bot" class="bot-imagem" />
      </div>
    </div>

    
    <script src="../../JS/FunçõesDoChatBot.js"></script>
    <script src="/projetopi/src/JS/nav.js"></script>
  </body>
</html>
