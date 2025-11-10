<?php
// 1. Inicia a sessão
// É preciso iniciar a sessão para poder "mexer" nela.
session_start();

// 2. Destrói todas as variáveis da sessão
// Isso limpa $_SESSION['user_id'], $_SESSION['user_nome'], etc.
$_SESSION = array();

// 3. Destrói a sessão
// Isso remove o "cookie" de sessão do navegador do usuário.
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finalmente, destrói a sessão no servidor
session_destroy();

// 4. Redireciona para a página de login
// Manda o usuário de volta para a tela de login.
// Use a tela de login que você preferir (a de paciente ou a de admin).
header('Location: /Lowcode-1/longui_paciente.html');
exit;
?>