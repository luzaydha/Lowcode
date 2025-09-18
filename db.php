<?php
// db.php
$host = 'localhost';
$user = 'root';
$pass = ''; // senha do MySQL (por padrão no XAMPP é vazia)
$dbname = 'clinica';
$port = 3307; // sua porta do MySQL

$mysqli = new mysqli($host, $user, $pass, $dbname, $port);

if ($mysqli->connect_errno) {
    die("Falha na conexão: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error);
}

// definir charset
$mysqli->set_charset('utf8mb4');
