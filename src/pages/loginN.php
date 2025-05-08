<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Página de Login - Finanças</title>
    <link rel="stylesheet" href="../styles/pasta Dos CSS/login.css" />
  </head>
  <body>
  <div class="login-container">
      <img
        src="https://static.vecteezy.com/ti/fotos-gratis/t2/23701963-selvagem-leopardo-animal-ilustracao-ai-generativo-gratis-foto.jpg"
        alt="Logo Auctus Fynance"
        class="logo"
      />
      <h2 class="slogan">
        O FUTURO DA SUA LIBERDADE <br /><span>FINANCEIRA</span>
      </h2>

      <?php
          if (isset($_GET['error'])) {
              echo "<div class='error'>" . htmlspecialchars($_GET['error']) . "</div>";
          }
          if (isset($_GET['success'])) {
              echo "<div class='success'>" . htmlspecialchars($_GET['success']) . "</div>";
          }
        ?>

      <form action="login.php" method="POST" class="login-form">
        <label for="email">Email</label>
        <input
          type="text"
          name="email"
          id="email"
          placeholder="Nome de Usuário / numero de Telefone"
          required
        />

        <label for="senha">Senha</label>
        <input
          type="password"
          name="senha"
          id="senha"
          placeholder="Senha"
          required
        />

        <div class="senha-link">
          <a href="../../public/paginicial.php" class=""
            >Voltar a pagina Inicial.</a
          >

          <a href="pasta%20Dos%20HTML/servicos.html">esqueceu a senha?</a>
        </div>

        <a href="cadastrar.php" class="sem-conta">Não possui cadastro?</a>

        <button type="submit" class="btn-cadastrar">CADASTRE-SE</button>
      </form>
    </div>
  </body>
</html>
