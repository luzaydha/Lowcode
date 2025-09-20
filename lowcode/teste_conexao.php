<?php
// teste_conexao.php
$host = 'localhost';
$user = 'root';
$pass = ''; // senha do MySQL (padrão no XAMPP é vazia)
$dbname = 'clinica';
$port = 3307; // porta do MySQL no seu XAMPP

$mysqli = new mysqli($host, $user, $pass, $dbname, $port);

if ($mysqli->connect_errno) {
    die("❌ Falha na conexão: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
} else {
    echo "✅ Conexão bem-sucedida com o banco de dados '<b>$dbname</b>' na porta <b>$port</b>!";
}
