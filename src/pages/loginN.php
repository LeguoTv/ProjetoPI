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
<<<<<<< HEAD
    <a href="../../public/paginicial.php">
      <img src="/ProjetoPI/src/assets/Imagens%20do%20Site/Conteudo%20do%20site/Logo%20Branca.png" 
            alt="Logo" 
            class="logo" 
            loading="lazy">
    </a>       
=======
      <a href="\ProjetoPI\public\paginicial.php">
        <img src="/ProjetoPI/src/assets/Imagens%20do%20Site/Conteudo%20do%20site/Logo%20Branca.png" 
        alt="Logo" 
        class="logo" 
        loading="lazy">
      </a>

>>>>>>> c1a7d4451d2a2dc72e89674946ea08ac80eb952c
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
          <a href="../../public/paginicial.php" class="Pag-Inicial"
            >Pagina Inicial.</a
          >

          <a href="pasta%20Dos%20HTML/servicos.html" class="Esq-Senha">Esqueceu a senha?</a>
        </div>

        <a href="cadastrar.php" class="sem-conta">Não possui cadastro?</a>

        <button type="submit" class="btn-cadastrar">FAZER LOGIN</button>
      </form>
    </div>
  </body>
</html>
