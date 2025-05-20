// Gera um sessionId único por usuário e salva no localStorage
let sessionId = localStorage.getItem("chat_session_id");
if (!sessionId) {
  sessionId = `sess-${Date.now()}-${Math.random().toString(36).substring(2, 10)}`;
  localStorage.setItem("chat_session_id", sessionId);
}

// Pega os principais elementos do chat no DOM
const botao = document.querySelector(".bot-imagem");
const expansao = document.querySelector(".chatExpandido");
const chatWrapper = document.querySelector(".ChatWrapper");
const form = document.getElementById("chat-form");
const input = document.getElementById("messageInput");
const chatbox = document.getElementById("chatbox");

let mensagemBoasVindasEnviada = false;
const MAX_MESSAGE_LENGTH = 1000; // limita o tamanho da mensagem
const FETCH_TIMEOUT_MS = 15000; // 15 segundos de tempo limite pro fetch

// Abre e fecha o chat ao clicar no botão flutuante
botao.addEventListener("click", () => {
  const estaAberto = expansao.style.height === "31rem";
  expansao.style.height = estaAberto ? "0" : "31rem";

  if (!estaAberto) {
    expansao.classList.add("aberto");

    // Só envia a mensagem de boas-vindas uma vez
    if (!mensagemBoasVindasEnviada) {
      appendMessage(
        "bot",
        "Olá! Sou o <b>BotAuctus</b>, seu assistente financeiro. " +
        "Estou aqui para ajudar você a organizar suas finanças e alcançar seus objetivos. Vamos juntos?",
        false,
        true // permite usar HTML (negrito, itálico, etc)
      );
      mensagemBoasVindasEnviada = true;
    }
  } else {
    expansao.classList.remove("aberto");
  }
});

// Fecha o chat se clicar fora dele
document.addEventListener("click", (e) => {
  if (!chatWrapper.contains(e.target)) {
    expansao.style.height = "0";
    expansao.classList.remove("aberto");
  }
});

// Envia a mensagem do usuário ao backend e exibe a resposta
form.addEventListener("submit", async (e) => {
  e.preventDefault();
  let message = input.value.trim();

  if (!message) return;

  // Bloqueia mensagens muito longas
  if (message.length > MAX_MESSAGE_LENGTH) {
    appendMessage("bot", "Mensagem muito longa. Por favor, resuma.", true);
    return;
  }

  appendMessage("user", message); // exibe a msg do usuário no chat
  input.value = "";
  input.disabled = true; // bloqueia o input enquanto o bot responde

  // Mostra o "digitando..." enquanto espera a resposta
  const typingId = appendMessage("bot", "<i>Digitando...</i>", false, true);

  // Cria um controlador de timeout pra não travar caso demore
  const controller = new AbortController();
  const timeoutId = setTimeout(() => controller.abort(), FETCH_TIMEOUT_MS);

  try {
    // Envia a requisição pro servidor com a mensagem e sessionId
    const res = await fetch("http://localhost:3000/chat", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ message, sessionId }),
      signal: controller.signal,
    });

    clearTimeout(timeoutId); // cancela o timeout, já que deu certo

    const data = await res.json();

    // Se a resposta veio certinha, substitui o "digitando..." pela resposta
    if (data.response) {
      updateMessage(typingId, data.response);
    } else {
      updateMessage(typingId, "Erro: resposta inválida do bot.", true);
    }
  } catch (err) {
    clearTimeout(timeoutId);

    // Trata timeout de forma específica
    if (err.name === "AbortError") {
      updateMessage(typingId, "Tempo de resposta excedido.", true);
    } else {
      updateMessage(typingId, "Erro ao conectar com o servidor.", true);
      console.error(err); // loga o erro no console pro dev ver
    }
  } finally {
    input.disabled = false;
    input.focus(); // foca no input de novo
  }
});

/**
 * Adiciona uma nova mensagem no chat.
 * @param {"user"|"bot"} role - quem está mandando a mensagem
 * @param {string} text - conteúdo da mensagem
 * @param {boolean} [isError=false] - se for uma mensagem de erro
 * @param {boolean} [rawHTML=false] - se true, insere HTML diretamente
 * @returns {number} - índice da mensagem (pra poder atualizar depois)
 */
function appendMessage(role, text, isError = false, rawHTML = false) {
  const div = document.createElement("div");
  div.classList.add("message", role);
  if (isError) div.classList.add("erro-bot");

  div.innerHTML = rawHTML ? text : formatMessage(text);
  chatbox.appendChild(div);
  chatbox.scrollTop = chatbox.scrollHeight;

  return chatbox.children.length - 1;
}

/**
 * Atualiza uma mensagem existente, geralmente o "digitando..."
 * @param {number} messageId - índice da mensagem no chat
 * @param {string} newText - novo conteúdo
 * @param {boolean} [isError=false] - se é erro, muda a classe
 * @param {boolean} [rawHTML=false] - se true, insere como HTML direto
 */
function updateMessage(messageId, newText, isError = false, rawHTML = false) {
  const div = chatbox.children[messageId];
  div.classList.toggle("erro-bot", isError);
  div.innerHTML = rawHTML ? newText : formatMessage(newText);
  chatbox.scrollTop = chatbox.scrollHeight;
}

/**
 * Formata texto com segurança e aplica markdown básico:
 *  - **negrito** vira <b>
 *  - _itálico_ vira <i>
 *  - \n vira <br>
 */
function formatMessage(text) {
  // Escapa caracteres HTML perigosos
  let safe = text
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");

  // Aplica estilo básico de markdown
  safe = safe
    .replace(/\*\*(.*?)\*\*/g, "<b>$1</b>")
    .replace(/_(.*?)_/g, "<i>$1</i>")
    .replace(/\n/g, "<br>");

  return safe;
}
