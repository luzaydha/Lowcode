<?php
// login.php
session_start();
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login_atendente_gerente.html');
    exit;
}

$email = isset($_POST['email']) ? $mysqli->real_escape_string(trim($_POST['email'])) : '';
$senha = isset($_POST['senha']) ? trim($_POST['senha']) : '';

if (empty($email) || empty($senha)) {
    $_SESSION['error'] = 'Preencha email e senha.';
    header('Location: login_atendente_gerente.html');
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

        // redireciona conforme role
        if ($row['role'] === 'paciente') {
            header('Location: paciente.html');
        } elseif ($row['role'] === 'atendente') {
            header('Location: atendente.html');
        } elseif ($row['role'] === 'gerente') {
            header('Location: gerente.html');
        } else {
            header('Location: longui_atendente_gerente.html');
        }
        exit;
    }
}

$_SESSION['error'] = 'Email ou senha inválidos.';
header('Location: longui_atendente_gerente.html');
exit;
