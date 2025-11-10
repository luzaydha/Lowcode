<?php
session_start();
ob_start();
require_once 'db.php';

$login_page = 'logui_atendente_gerente.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $login_page);
    exit;
}

$email = isset($_POST['email']) ? $mysqli->real_escape_string(trim($_POST['email'])) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

if (empty($email) || empty($senha)) {
    $_SESSION['error'] = 'Preencha email e senha.';
    header('Location: ' . $login_page);
    exit;
}

// Buscar usuário
$sql = "SELECT id, nome, email, senha, role FROM usuarios WHERE email = ? LIMIT 1";
$stmt = $mysqli->prepare($sql);
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $row = $result->fetch_assoc()) {
    if (password_verify($senha, $row['senha'])) {
        // Login OK
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_nome'] = $row['nome'];
        $_SESSION['user_role'] = $row['role'];

        // Redirecionamento por função
        switch ($row['role']) {
            case 'paciente':
                header('Location: /Lowcode-1/paciente/paciente.php');
                break;
            case 'atendente':
                header('Location: /Lowcode-1/atendente.html');
                break;
            case 'gerente':
                header('Location: /Lowcode-1/gerente.html');
                break;
            default:
                $_SESSION['error'] = 'Função de usuário desconhecida.';
                header('Location: ' . $login_page);
        }
        exit;
    } else {
        $_SESSION['error'] = 'Email ou senha inválidos.';
        header('Location: ' . $login_page);
        exit;
    }
} else {
    $_SESSION['error'] = 'Email ou senha inválidos.';
    header('Location: ' . $login_page);
    exit;
}
