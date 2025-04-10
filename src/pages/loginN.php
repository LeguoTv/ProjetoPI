<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../styles/pasta Dos CSS/login.css" />
    <title>Página de Login - Finanças</title>
  </head>
  <body>
    <div class="container">
      <div class="login-box">
      <?php
  if (isset($_GET['error'])) {
      echo "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>";
  }
  if (isset($_GET['success'])) {
      echo "<div class='success'>" . htmlspecialchars($_GET['success']) . "</div>";
  }
  ?>
        <h2>Entre na sua Conta</h2>
        
        <form action="login.php" method="post">
          <div class="input-group">
            <label for="username">Usuário</label>
            <input
              type="text"
              id="username"
              placeholder="Digite seu nome de usuário"
              required
            />
          </div>
          <div class="input-group">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="E-mail" required />
          </div>
          <div class="input-group">
            <label for="password">Senha</label>
            <input type="password" name="senha" placeholder="Senha" required />
          </div>

          <input class="button" type="submit" value="Entrar" />
        </form>
        <p class="forgot-password"><a href="pasta%20Dos%20HTML/servicos.html">Esqueceu sua senha?</a></p>
        <a href="pasta Dos HTML/inicio.html" class="botao-voltar">Voltar</a>
      </div>
    </div>
  </body>
</html>
