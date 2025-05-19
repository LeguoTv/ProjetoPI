// 🔐 Geração de sessionId única por usuário
let sessionId = localStorage.getItem("chat_session_id");
if (!sessionId) {
  sessionId = `sess-${Date.now()}-${Math.random().toString(36).substring(2, 10)}`;
  localStorage.setItem("chat_session_id", sessionId);
}

// 🎯 Seleciona elementos principais do chat
const botao = document.querySelector(".bot-imagem");
const expansao = document.querySelector(".chatExpandido");
const chatWrapper = document.querySelector(".ChatWrapper");
const form = document.getElementById("chat-form");
const input = document.getElementById("messageInput");
const chatbox = document.getElementById("chatbox");

let mensagemBoasVindasEnviada = false;
const MAX_MESSAGE_LENGTH = 1000;
const FETCH_TIMEOUT_MS = 15000; // 15 segundos

// 🚀 Handler de clique no botão de chat
botao.addEventListener("click", () => {
  const estaAberto = expansao.style.height === "31rem";
  expansao.style.height = estaAberto ? "0" : "31rem";

  if (!estaAberto) {
    expansao.classList.add("aberto");
    if (!mensagemBoasVindasEnviada) {
      appendMessage("bot",
        "Olá! Sou o <b>BotAuctus</b>, seu assistente financeiro. " +
        "Estou aqui para ajudar você a organizar suas finanças e alcançar seus objetivos. Vamos juntos?"
      );
      mensagemBoasVindasEnviada = true;
    }
  } else {
    expansao.classList.remove("aberto");
  }
});

// ❌ Fecha o chat ao clicar fora
document.addEventListener("click", (e) => {
  if (!chatWrapper.contains(e.target)) {
    expansao.style.height = "0";
    expansao.classList.remove("aberto");
  }
});

// 💬 Handler de envio do formulário
form.addEventListener("submit", async (e) => {
  e.preventDefault();
  let message = input.value.trim();

  // 🚫 Limita o tamanho da mensagem
  if (!message) return;
  if (message.length > MAX_MESSAGE_LENGTH) {
    appendMessage("bot", "Mensagem muito longa. Por favor, resuma.", true);
    return;
  }

  // 🧱 Mostra a mensagem do usuário
  appendMessage("user", sanitize(message));
  input.value = "";
  input.disabled = true;

  // 💭 Indicador de "digitando"
  const typingId = appendMessage("bot", "<i>Digitando...</i>");

  // ⏱️ Configura timeout para o fetch
  const controller = new AbortController();
  const timeoutId = setTimeout(() => controller.abort(), FETCH_TIMEOUT_MS);

  try {
    const res = await fetch("http://localhost:3000/chat", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify({ message, sessionId }),
      signal: controller.signal,
    });
    clearTimeout(timeoutId);

    const data = await res.json();

    // Substitui "digitando" pela resposta ou erro
    if (data.response) {
      updateMessage(typingId, sanitize(data.response));
    } else {
      updateMessage(typingId, "Erro: resposta inválida do bot.", true);
    }
  } catch (err) {
    clearTimeout(timeoutId);
    if (err.name === "AbortError") {
      updateMessage(typingId, "⏱️ Tempo de resposta excedido.", true);
    } else {
      updateMessage(typingId, "Erro ao conectar com o servidor.", true);
      console.error(err);
    }
  } finally {
    input.disabled = false;
    input.focus();
  }
});

/**
 * Adiciona uma nova mensagem ao chat.
 * @param {"user"|"bot"} role 
 * @param {string} text 
 * @param {boolean} [isError=false]
 * @returns {number} id da mensagem (índice no chatbox)
 */
function appendMessage(role, text, isError = false) {
  const div = document.createElement("div");
  div.classList.add("message", role);
  if (isError) div.classList.add("erro-bot");
  div.innerHTML = formatMessage(text);
  chatbox.appendChild(div);
  chatbox.scrollTop = chatbox.scrollHeight;
  return chatbox.children.length - 1;
}

/**
 * Atualiza o conteúdo de uma mensagem já existente.
 * @param {number} messageId índice da mensagem
 * @param {string} newText texto formatado
 * @param {boolean} [isError=false]
 */
function updateMessage(messageId, newText, isError = false) {
  const div = chatbox.children[messageId];
  div.classList.toggle("erro-bot", isError);
  div.innerHTML = formatMessage(newText);
  chatbox.scrollTop = chatbox.scrollHeight;
}

/**
 * Formata texto: escapa HTML para segurança, depois aplica markdown básico.
 * Suporta:
 *  - **negrito**
 *  - _itálico_
 *  - quebras de linha (\n)
 * @param {string} text 
 * @returns {string} HTML formatado seguro
 */
function formatMessage(text) {
  // Escapa HTML para evitar injeção
  let safe = text
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;");

  // Aplica negrito e itálico markdown (pós escape)
  safe = safe
    .replace(/\*\*(.*?)\*\*/g, "<b>$1</b>")   // **negrito**
    .replace(/_(.*?)_/g, "<i>$1</i>")         // _itálico_
    .replace(/\n/g, "<br>");                   // quebras de linha

  return safe;
}

/**
 * Sanitiza string para evitar injeção de HTML.
 * @param {string} str 
 * @returns {string}
 */
function sanitize(str) {
  return str
    .replace(/&/g, "&amp;")
    .replace(/</g, "&lt;")
    .replace(/>/g, "&gt;")
    .replace(/"/g, "&quot;")
    .replace(/'/g, "&#039;");
}
