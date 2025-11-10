<?php
// login.php
session_start();
require_once 'db.php';

// Caminho absoluto para a tela de login principal
$login_page = '/Lowcode-1/logui_atendente_gerente.html';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    // CORRIGIDO: Redireciona para o caminho absoluto
    header('Location: ' . $login_page);
    exit;
}

$email = isset($_POST['email']) ? $mysqli->real_escape_string(trim($_POST['email'])) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

if (empty($email) || empty($senha)) {
    $_SESSION['error'] = 'Preencha email e senha.';
    // CORRIGIDO: Redireciona para o caminho absoluto
    header('Location: ' . $login_page);
    exit;
}

// busca usuário
$sql = "SELECT id, nome, email, senha, role FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    $stored = $row['senha'];

    // Recomendado e seguro:
    if (password_verify($senha, $stored)) {
        // login OK
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_nome'] = $row['nome'];
        $_SESSION['user_role'] = $row['role'];

        // === CORREÇÃO PRINCIPAL AQUI ===
        // Redireciona usando caminhos absolutos
        
        if ($row['role'] === 'paciente') {
            // CORRIGIDO: Aponta para o arquivo na RAIZ
            header('Location: /Lowcode-1/paciente.html');
            
        } elseif ($row['role'] === 'atendente') {
            // CORRIGIDO: Caminho absoluto
            header('Location: /Lowcode-1/atendente.html');
            
        } elseif ($row['role'] === 'gerente') {
            // CORRIGIDO: Caminho absoluto
            header('Location: /Lowcode-1/gerente.html');
            
        } else {
            // CORRIGIDO: Caminho absoluto para a página de login
            header('Location: ' . $login_page);
        }
        exit;
    }
}

// CORRIGIDO: Caminho absoluto para a página de login
$_SESSION['error'] = 'Email ou senha inválidos.';
header('Location: ' . $login_page);
exit;