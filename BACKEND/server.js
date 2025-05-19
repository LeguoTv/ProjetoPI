// Importação dos módulos necessários
import express from "express";
import cors from "cors";
import bodyParser from "body-parser";
import { OpenAI } from "openai/index.mjs";
import dotenv from "dotenv";
import path from "path";
import { fileURLToPath } from "url";
import fs from "fs";

// Para usar __dirname com ESModules
const __filename = fileURLToPath(import.meta.url);
const __dirname = path.dirname(__filename);

// Carrega variáveis de ambiente do .env
dotenv.config({ path: path.join(__dirname, ".env") });

// Inicializa o servidor
const app = express();
const port = 3000;

app.use(cors());
app.use(bodyParser.json());

// Verifica se a chave da OpenAI está presente
if (!process.env.OPENAI_API_KEY) {
    console.error("❌ ERRO: A variável OPENAI_API_KEY não está definida no .env");
    process.exit(1);
}

// Inicializa a instância da OpenAI
const openai = new OpenAI({
    apiKey: process.env.OPENAI_API_KEY,
});

// Lê o prompt do arquivo externo
let systemPrompt = "";
try {
    systemPrompt = fs.readFileSync(path.join(__dirname, "prompt.txt"), "utf-8");
    if (!systemPrompt.trim()) throw new Error("prompt.txt está vazio");
} catch (err) {
    console.error("❌ Erro ao ler o prompt.txt:", err.message);
    process.exit(1);
}

// Histórico de chat por sessão
const chatHistory = {};

// Rota principal do chat
app.post("/chat", async (req, res) => {
    const { message, sessionId = "default" } = req.body;

    // Validação básica
    if (!message || typeof message !== "string" || !message.trim()) {
        return res.status(400).json({ error: "Mensagem inválida." });
    }

    // Garante que o sessionId é string simples
    const safeSessionId = String(sessionId).replace(/[^a-zA-Z0-9_-]/g, "");

    // Inicializa histórico da sessão se necessário
    if (!chatHistory[safeSessionId]) {
        chatHistory[safeSessionId] = [];
    }

    // Adiciona a mensagem do usuário
    chatHistory[safeSessionId].push({ role: "user", content: message });

    console.log(`🔹 [${safeSessionId}] Mensagem recebida:`, message);

    try {
        const response = await openai.chat.completions.create({
            model: "gpt-4o",
            messages: [
                { role: "system", content: systemPrompt },
                ...chatHistory[safeSessionId],
            ],
        });

        if (!response.choices || response.choices.length === 0) {
            throw new Error("Resposta vazia da API");
        }

        const botResponse = response.choices[0].message.content;
        console.log(`✅ [${safeSessionId}] Resposta da API:`, botResponse);

        // Armazena a resposta do bot no histórico
        chatHistory[safeSessionId].push({ role: "assistant", content: botResponse });

        res.json({ response: botResponse });

    } catch (err) {
        console.error(`❌ [${safeSessionId}] Erro ao processar mensagem:`, err.message);
        res.status(500).json({
            error: "Erro ao obter resposta. Tente novamente mais tarde.",
            response: "Desculpe, estou com dificuldades técnicas no momento. Tente novamente em breve!",
        });
    }
});

// Inicia o servidor
app.listen(port, () => {
    console.log(`🚀 BotAuctus rodando em http://localhost:${port}`);
});
