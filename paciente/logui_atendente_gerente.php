<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Clínica MediConnectPro</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap");
    body {
      font-family: "Inter", sans-serif;
      background-color: #f0f4f8;
    }
    .gradient-text {
      background: linear-gradient(to right, #0077b6, #00d1c7);
      -webkit-background-clip: text;
      -webkit-text-fill-color: transparent;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
  <div class="bg-white rounded-3xl shadow-xl max-w-lg w-full p-8 sm:p-12 text-center">
    <h1 class="text-4xl font-bold mb-2 gradient-text">Acesso ao MediConnect Pro</h1>
    
    <p id="form-subtitle" class="text-lg text-gray-500 mb-8">Faça login na sua conta</p>

   
    <form action="paciente/login.php" method="POST" class="space-y-6">
      <input
        type="email"
        name="email"
        placeholder="Email"
        required
        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
      />
      <input
        type="password"
        name="senha"
        placeholder="Senha"
        required
        class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 transition-colors"
      />
      <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-3 rounded-2xl transition duration-300 transform hover:scale-105 shadow-lg">
        Entrar
      </button>
    </form>
    
  </div>
</body>
</html>