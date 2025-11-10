<?php
// 1. INICIA A SESSÃO
// Essencial para usarmos $_SESSION para enviar mensagens de erro/sucesso
session_start();

// 2. INCLUI A CONEXÃO COM O BANCO
require_once 'db.php';

// 3. DEFINE O CAMINHO DA PÁGINA DE CADASTRO
// (Isso ajuda a evitar erros de 404 ao redirecionar)
$cadastro_page = '/Lowcode-1/paciente/cadastro.html';
$login_page = '/Lowcode-1/longui_paciente.html'; // Ou o login que preferir

// 4. VERIFICA SE O MÉTODO É POST
// Se alguém tentar acessar 'register.php' direto pelo navegador, expulsa
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . $cadastro_page);
    exit;
}

// 5. COLETA E LIMPA OS DADOS DO FORMULÁRIO
// Usamos trim() para remover espaços em branco
$nome = trim($_POST['nome'] ?? '');
$dataNascimento = trim($_POST['dataNascimento'] ?? '');
$cpf = trim($_POST['cpf'] ?? '');
$email = trim($_POST['email'] ?? '');
$telefone = trim($_POST['telefone'] ?? '');
$senha = trim($_POST['senha'] ?? '');
$confirmaSenha = trim($_POST['confirmaSenha'] ?? '');

// 6. VALIDAÇÃO BÁSICA NO LADO DO SERVIDOR
// (O JavaScript já valida, mas nunca confie 100% no JavaScript)
$errors = [];
if (empty($nome)) {
    $errors[] = "Nome é obrigatório.";
}
if (empty($email)) {
    $errors[] = "Email é obrigatório.";
}
if (empty($cpf)) {
    $errors[] = "CPF é obrigatório.";
}
if (empty($senha)) {
    $errors[] = "Senha é obrigatória.";
}
if ($senha !== $confirmaSenha) {
    $errors[] = "As senhas não coincidem.";
}

// Se houver erros de validação, volta para o cadastro
if (!empty($errors)) {
    // Vamos juntar todos os erros em uma única mensagem
    $_SESSION['error'] = implode(' ', $errors);
    header('Location: ' . $cadastro_page);
    exit;
}

// 7. VERIFICA SE O EMAIL OU CPF JÁ EXISTEM
// Isso impede usuários duplicados
$sql_check = "SELECT id FROM usuarios WHERE email = ? OR cpf = ? LIMIT 1";
$stmt_check = $mysqli->prepare($sql_check);
// 'ss' = string, string
$stmt_check->bind_param('ss', $email, $cpf);
$stmt_check->execute();
$result_check = $stmt_check->get_result();

if ($result_check->num_rows > 0) {
    // Se encontrou, define o erro e volta
    $_SESSION['error'] = 'Email ou CPF já cadastrado.';
    header('Location: ' . $cadastro_page);
    exit;
}

// 8. CRIPTOGRAFA A SENHA (SEGURANÇA)
// Esta é a forma correta de armazenar senhas.
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// 9. INSERE O NOVO USUÁRIO NO BANCO
// Assumindo que o 'role' padrão para quem se cadastra é 'paciente'
$role = 'paciente';

// ATENÇÃO: Verifique se sua tabela 'usuarios' tem as colunas:
// nome, data_nascimento, cpf, email, telefone, senha, role
$sql_insert = "INSERT INTO usuarios (nome, data_nascimento, cpf, email, telefone, senha, role) 
               VALUES (?, ?, ?, ?, ?, ?, ?)";
               
$stmt_insert = $mysqli->prepare($sql_insert);
// 'sssssss' = string, string, string, string, string, string, string
$stmt_insert->bind_param('sssssss', 
    $nome, 
    $dataNascimento, 
    $cpf, 
    $email, 
    $telefone, 
    $senha_hash, 
    $role
);

// 10. EXECUTA E REDIRECIONA
if ($stmt_insert->execute()) {
    // Sucesso!
    $_SESSION['success'] = 'Cadastro realizado com sucesso! Faça o login.';
    header('Location: ' . $login_page);
} else {
    // Falha no banco de dados
    $_SESSION['error'] = 'Erro ao cadastrar. Tente novamente. ' . $mysqli->error;
    header('Location: ' . $cadastro_page);
}

// Fecha as conexões
$stmt_check->close();
$stmt_insert->close();
$mysqli->close();
exit;

?>