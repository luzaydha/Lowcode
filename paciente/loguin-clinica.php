<?php
session_start(); 

// 1. PREPARA A MENSAGEM DE ERRO (se ela existir)
$error_message = null; // Começa vazia
if (isset($_SESSION['error'])) {
    $error_message = htmlspecialchars($_SESSION['error']);
    unset($_SESSION['error']); // Limpa a mensagem para não mostrar de novo
}

// 2. PREPARA A MENSAGEM DE SUCESSO (se ela existir)
$success_message = null; // Começa vazia
if (isset($_SESSION['success'])) {
    $success_message = htmlspecialchars($_SESSION['success']);
    unset($_SESSION['success']); // Limpa a mensagem para não mostrar de novo
}

// 3. CHAMA O ARQUIVO DE VISUALIZAÇÃO (O "Rosto")
// O "Cérebro" manda o "Rosto" aparecer e entrega as mensagens para ele.
require 'logui_atendente_gerente.php';

