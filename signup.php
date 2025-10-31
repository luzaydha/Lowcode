<?php
// signup.php
session_start();
require_once 'db.php'; // Inclui o seu arquivo de conexão

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: login_clinica.html');
    exit;
}

// 1. Coleta de dados básicos
$role = isset($_POST['role']) ? $_POST['role'] : '';
$name = isset($_POST['name']) ? $mysqli->real_escape_string(trim($_POST['name'])) : '';
$email = isset($_POST['email']) ? $mysqli->real_escape_string(trim($_POST['email'])) : '';
$senha = isset($_POST['senha']) ? $_POST['senha'] : ''; // Senha sem trim ou real_escape_string

if (empty($role) || empty($name) || empty($email) || empty($senha)) {
    $_SESSION['error'] = 'Preencha todos os campos obrigatórios.';
    header('Location: login_clinica.html');
    exit;
}

// 2. Verifica se o email já existe
$check_sql = "SELECT id FROM usuarios WHERE email = ? LIMIT 1";
$check_stmt = $mysqli->prepare($check_sql);
$check_stmt->bind_param('s', $email);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    $_SESSION['error'] = 'Este email já está cadastrado.';
    header('Location: login_clinica.html');
    exit;
}

// 3. Cria o hash da senha de forma segura
$hashed_senha = password_hash($senha, PASSWORD_DEFAULT);

// 4. Tratamento de campos específicos do paciente
$telefone = null;
$cpf = null;
$data_nascimento = null;
$endereco = null;
$cidade = null;
$estado = null;

if ($role === 'paciente') {
    $telefone = isset($_POST['telefone']) ? $mysqli->real_escape_string(trim($_POST['telefone'])) : null;
    $cpf = isset($_POST['cpf']) ? $mysqli->real_escape_string(trim($_POST['cpf'])) : null;
    $data_nascimento = isset($_POST['data_nascimento']) ? $mysqli->real_escape_string(trim($_POST['data_nascimento'])) : null;
    $endereco = isset($_POST['endereco']) ? $mysqli->real_escape_string(trim($_POST['endereco'])) : null;
    $cidade = isset($_POST['cidade']) ? $mysqli->real_escape_string(trim($_POST['cidade'])) : null;
    $estado = isset($_POST['estado']) ? $mysqli->real_escape_string(trim($_POST['estado'])) : null;
}

// 5. Inserção no banco de dados (Query adaptada para todos os campos)
$sql = "INSERT INTO usuarios (nome, email, senha, role, telefone, cpf, data_nascimento, endereco, cidade, estado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
$stmt = $mysqli->prepare($sql);

// Tipos de dados: s=string, i=integer, d=double, b=blob. Usamos 's' para tudo que é string ou NULL.
$stmt->bind_param(
    'ssssssssss', 
    $name, 
    $email, 
    $hashed_senha, 
    $role, 
    $telefone, 
    $cpf, 
    $data_nascimento, 
    $endereco, 
    $cidade, 
    $estado
);

if ($stmt->execute()) {
    $_SESSION['success'] = 'Cadastro realizado com sucesso! Faça login.';
    header('Location: login_clinica.html');
    exit;
} else {
    // Erro na execução
    $_SESSION['error'] = 'Erro ao cadastrar usuário: ' . $stmt->error;
    header('Location: login_clinica.html');
    exit;
}

$stmt->close();
$mysqli->close();
?>
