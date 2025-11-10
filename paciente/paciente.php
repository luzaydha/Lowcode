<?php
session_start();
$login_page = '/paciente/paciente.php';
if (!isset($_SESSION['user_id'])) {
   
    header('Location: ' . $login_page);
    exit;
}

// 4. (Opcional) Verifica se o 'role' é de paciente
// Se um atendente tentar acessar a página do paciente, ele é expulso.
if ($_SESSION['user_role'] !== 'paciente') {
    // Você pode criar uma página "acesso_negado.html" ou apenas deslogá-lo
    session_destroy(); // Destrói a sessão por segurança
    header('Location: ' . $login_page);
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<!DOCTYPE html>
<html lang="pt-BR">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Perfil do Paciente</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
      /* Estilo para garantir que o corpo ocupe toda a altura e para a fonte Inter */
      @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");
      body {
        font-family: "Inter", sans-serif;
        background-color: #f0f4f8;
      }
      /* Estilos para a barra de rolagem no histórico de conversas */
      .chat-history::-webkit-scrollbar {
        width: 6px;
      }
      .chat-history::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
      }
      .chat-history::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
      }
      .chat-history::-webkit-scrollbar-thumb:hover {
        background: #555;
      }
      /* Efeito de transição suave nos botões de abas */
      .tab-button {
        transition: all 0.3s ease-in-out;
      }
    </style>
  </head>
  <body class="flex items-center justify-center min-h-screen p-4">
    <div
      class="w-full max-w-4xl mx-auto bg-white rounded-2xl shadow-lg overflow-hidden md:flex"
    >
      <!-- Barra Lateral com Informações do Paciente -->
      <div
        class="md:w-1/3 bg-sky-50 p-6 flex flex-col items-center text-center"
      >
        <img
          class="w-24 h-24 rounded-full border-4 border-sky-200 object-cover"
          src="https://placehold.co/100x100/E2E8F0/4A5568?text=AS"
          alt="Foto do Paciente"
        />
       <h1 class="text-xl font-bold text-gray-800 mt-4">
          <?php echo htmlspecialchars($_SESSION['user_nome']); ?>
        </h1>
                <p class="text-sm text-gray-600">
          ID do Paciente: <?php echo htmlspecialchars($_SESSION['user_id']); ?>
        </p>
        <div class="mt-6 text-left w-full">
          <h2 class="text-md font-semibold text-gray-700 border-b pb-2">
            Informações de Contato
          </h2>
          <div class="text-sm text-gray-600 mt-3 space-y-2">
            <p class="flex items-center">
              <i data-lucide="mail" class="w-4 h-4 mr-2 text-sky-500"></i>
                            a.silva@email.com 
            </p>
          </div>
        </div>
        <div class="mt-auto pt-6">
          <a
            href="/Lowcode-1/logout.php" 
            class="w-full bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition-colors flex items-center justify-center"
          >
            <i data-lucide="log-out" class="w-4 h-4 mr-2"></i>
            Sair
        </a>
        </div>
      </div>

      <!-- Conteúdo Principal com Abas -->
      <div class="md:w-2/3 p-6 sm:p-8">
        <!-- Abas de Navegação -->
        <div class="border-b border-gray-200">
          <nav class="flex space-x-2 sm:space-x-4" aria-label="Tabs">
            <button
              id="tab-lembretes"
              class="tab-button text-sky-600 border-b-2 border-sky-600 py-2 px-3 text-sm font-semibold"
            >
              Lembretes
            </button>
            <button
              id="tab-mensagens"
              class="tab-button text-gray-500 hover:text-sky-600 hover:border-b-2 hover:border-sky-300 py-2 px-3 text-sm font-semibold"
            >
              Mensagens
            </button>
            <button
              id="tab-exames"
              class="tab-button text-gray-500 hover:text-sky-600 hover:border-b-2 hover:border-sky-300 py-2 px-3 text-sm font-semibold"
            >
              Exames Disponíveis
            </button>
          </nav>
        </div>

        <!-- Conteúdo das Abas -->
        <div class="mt-6">
          <!-- Seção de Lembretes (Visível por padrão) -->
          <div id="content-lembretes" class="space-y-4">
            <h2 class="text-lg font-bold text-gray-800">
              Agendamentos e Lembretes
            </h2>
            <div
              class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-r-lg"
              role="alert"
            >
              <p class="font-bold flex items-center">
                <i data-lucide="check-circle-2" class="w-5 h-5 mr-2"></i
                >Consulta Confirmada
              </p>
              <p class="text-sm">
                Sua consulta com Dr. André Costa foi agendada para
                <strong>25/09/2025 às 14:30</strong>.
              </p>
            </div>
            <div
              class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-800 p-4 rounded-r-lg"
              role="alert"
            >
              <p class="font-bold flex items-center">
                <i data-lucide="bell" class="w-5 h-5 mr-2"></i>Lembrete de
                Consulta
              </p>
              <p class="text-sm">
                Não se esqueça da sua consulta amanhã com Dra. Sofia Martins às
                <strong>10:00</strong>.
              </p>
            </div>
            <div
              class="bg-sky-50 border-l-4 border-sky-500 text-sky-800 p-4 rounded-r-lg"
              role="alert"
            >
              <p class="font-bold flex items-center">
                <i data-lucide="info" class="w-5 h-5 mr-2"></i>Exame Pronto
              </p>
              <p class="text-sm">
                Seu resultado de exame de sangue já está disponível no portal.
              </p>
            </div>
          </div>

          <!-- Seção de Mensagens (Histórico e Nova Mensagem combinados) -->
          <div id="content-mensagens" class="hidden">
            <h2 class="text-lg font-bold text-gray-800 mb-4">
              Histórico de Conversas
            </h2>
            <div
              id="chat-container"
              class="chat-history h-64 overflow-y-auto bg-gray-50 p-4 rounded-lg space-y-4"
            >
              <!-- Mensagens serão inseridas aqui pelo JavaScript -->
            </div>
            <!-- Formulário de Envio de Nova Mensagem -->
            <div class="mt-6 pt-6 border-t">
              <h2 class="text-lg font-bold text-gray-800 mb-4">
                Enviar Nova Mensagem
              </h2>
              <div>
                <label
                  for="message"
                  class="block text-sm font-medium text-gray-700"
                  >Sua mensagem</label
                >
                <textarea
                  id="message"
                  rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-sky-500 focus:ring-sky-500 sm:text-sm"
                  placeholder="Digite sua dúvida ou solicitação..."
                ></textarea>
              </div>
              <div class="mt-4">
                <p class="text-sm font-medium text-gray-700">
                  Selecione o canal de envio:
                </p>
                <div class="flex items-center space-x-4 mt-2">
                  <button
                    data-channel="WhatsApp"
                    class="channel-btn flex-1 bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600 flex items-center justify-center transition-transform transform hover:scale-105"
                  >
                    <i data-lucide="message-square" class="w-5 h-5 mr-2"></i>
                    WhatsApp
                  </button>
                  <button
                    data-channel="Email"
                    class="channel-btn flex-1 bg-sky-500 text-white py-2 px-4 rounded-lg hover:bg-sky-600 flex items-center justify-center transition-transform transform hover:scale-105"
                  >
                    <i data-lucide="mail" class="w-5 h-5 mr-2"></i> Email
                  </button>
                  <button
                    data-channel="Instagram"
                    class="channel-btn flex-1 bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600 flex items-center justify-center transition-transform transform hover:scale-105"
                  >
                    <i data-lucide="instagram" class="w-5 h-5 mr-2"></i>
                    Instagram
                  </button>
                </div>
              </div>
              <div
                id="feedback-message"
                class="mt-4 text-sm font-medium text-green-600 h-5"
              ></div>
            </div>
          </div>

          <!-- Seção de Exames Disponíveis (Oculta por padrão) -->
          <div id="content-exames" class="hidden">
            <h2 class="text-lg font-bold text-gray-800 mb-4">
              Exames Disponíveis
            </h2>
            <div class="space-y-4">
              <div
                class="bg-gray-50 p-4 rounded-lg flex justify-between items-center border border-gray-200"
              >
                <div>
                  <p class="font-semibold text-gray-700">Hemograma Completo</p>
                  <p class="text-sm text-gray-500">Data: 10/09/2025</p>
                </div>
                <button
                  class="bg-sky-500 text-white py-2 px-4 rounded-lg hover:bg-sky-600 flex items-center justify-center text-sm"
                >
                  <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                  Ver Resultado
                </button>
              </div>
              <div
                class="bg-gray-50 p-4 rounded-lg flex justify-between items-center border border-gray-200"
              >
                <div>
                  <p class="font-semibold text-gray-700">Glicemia de Jejum</p>
                  <p class="text-sm text-gray-500">Data: 10/09/2025</p>
                </div>
                <button
                  class="bg-sky-500 text-white py-2 px-4 rounded-lg hover:bg-sky-600 flex items-center justify-center text-sm"
                >
                  <i data-lucide="download" class="w-4 h-4 mr-2"></i>
                  Ver Resultado
                </button>
              </div>
              <div
                class="bg-gray-50 p-4 rounded-lg flex justify-between items-center border border-gray-200"
              >
                <div>
                  <p class="font-semibold text-gray-700">
                    Colesterol Total e Frações
                  </p>
                  <p class="text-sm text-gray-500">Data: 05/08/2025</p>
                </div>
                <button
                  class="bg-gray-400 text-white py-2 px-4 rounded-lg flex items-center justify-center text-sm cursor-not-allowed"
                  disabled
                >
                  <i data-lucide="clock" class="w-4 h-4 mr-2"></i>
                  Pendente
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script>
      // Inicializa os ícones da biblioteca Lucide
      lucide.createIcons();

      // Dados de exemplo para o histórico de conversas
      const initialChatHistory = [
        {
          sender: "Paciente",
          text: "Bom dia, gostaria de saber o resultado do meu exame de sangue.",
          time: "10:30",
        },
        {
          sender: "Clinica",
          text: "Bom dia, Ana! Só um momento, vou verificar no sistema.",
          time: "10:31",
        },
        {
          sender: "Clinica",
          text: "Verifiquei aqui. O resultado já está disponível no portal do paciente.",
          time: "10:33",
        },
      ];

      // Elementos do DOM
      const tabs = document.querySelectorAll(".tab-button");
      const contents = document.querySelectorAll('[id^="content-"]');
      const messageInput = document.getElementById("message");
      const channelButtons = document.querySelectorAll(".channel-btn");
      const feedbackMessage = document.getElementById("feedback-message");
      const chatContainer = document.getElementById("chat-container");

      // Função para carregar e exibir o histórico de chat inicial
      function loadChatHistory() {
        chatContainer.innerHTML = ""; // Limpa o container
        initialChatHistory.forEach((msg) => {
          const messageElement = createMessageElement(
            msg.sender,
            msg.text,
            msg.time
          );
          chatContainer.appendChild(messageElement);
        });
        chatContainer.scrollTop = chatContainer.scrollHeight; // Rola para a última mensagem
      }

      // Função para criar um elemento de mensagem do chat
      function createMessageElement(sender, text, time) {
        const messageWrapper = document.createElement("div");
        const messageBubble = document.createElement("div");
        const timeElement = document.createElement("div");

        const isPatient = sender === "Paciente";

        messageWrapper.className = `flex items-end gap-2 ${
          isPatient ? "justify-end" : "justify-start"
        }`;
        messageBubble.className = `max-w-xs md:max-w-md p-3 rounded-lg ${
          isPatient
            ? "bg-sky-500 text-white rounded-br-none"
            : "bg-gray-200 text-gray-800 rounded-bl-none"
        }`;
        messageBubble.textContent = text;
        timeElement.className = `text-xs text-gray-400 mt-1 ${
          isPatient ? "text-right" : "text-left"
        }`;
        timeElement.textContent = time;

        const innerWrapper = document.createElement("div");
        innerWrapper.appendChild(messageBubble);
        innerWrapper.appendChild(timeElement);

        if (isPatient) {
          messageWrapper.appendChild(innerWrapper);
        } else {
          const avatar = document.createElement("img");
          avatar.src = "https://placehold.co/32x32/94A3B8/FFFFFF?text=C";
          avatar.alt = "Avatar Clínica";
          avatar.className = "w-8 h-8 rounded-full";
          messageWrapper.appendChild(avatar);
          messageWrapper.appendChild(innerWrapper);
        }

        return messageWrapper;
      }

      // Função para alternar entre as abas
      function switchTab(targetId) {
        contents.forEach((content) => {
          content.classList.add("hidden");
        });
        document
          .getElementById(`content-${targetId}`)
          .classList.remove("hidden");

        tabs.forEach((tab) => {
          tab.classList.remove("text-sky-600", "border-sky-600");
          tab.classList.add("text-gray-500");
        });
        document
          .getElementById(`tab-${targetId}`)
          .classList.add("text-sky-600", "border-b-2", "border-sky-600");
      }

      // Adiciona event listeners para os botões das abas
      tabs.forEach((tab) => {
        tab.addEventListener("click", () => {
          const targetId = tab.id.split("-")[1];
          switchTab(targetId);
        });
      });

      // Adiciona event listeners para os botões de canal (envio de mensagem)
      channelButtons.forEach((button) => {
        button.addEventListener("click", () => {
          const messageText = messageInput.value.trim();
          const channel = button.dataset.channel;

          if (!messageText) {
            feedbackMessage.textContent = "Por favor, digite uma mensagem.";
            feedbackMessage.className =
              "mt-4 text-sm font-medium text-red-600 h-5";
            setTimeout(() => (feedbackMessage.textContent = ""), 3000);
            return;
          }

          // Simula o envio
          const now = new Date();
          const timeString = `${now
            .getHours()
            .toString()
            .padStart(2, "0")}:${now.getMinutes().toString().padStart(2, "0")}`;
          const newMessage = {
            sender: "Paciente",
            text: messageText,
            time: `${timeString}`,
          };

          initialChatHistory.push(newMessage);
          loadChatHistory();

          // Feedback visual
          feedbackMessage.textContent = `Mensagem enviada via ${channel}!`;
          feedbackMessage.className =
            "mt-4 text-sm font-medium text-green-600 h-5";
          messageInput.value = "";

          setTimeout(() => {
            feedbackMessage.textContent = "";
          }, 2000);
        });
      });

      // Carrega o histórico de chat ao iniciar a página
      loadChatHistory();
    </script>
  </body>
</html>
