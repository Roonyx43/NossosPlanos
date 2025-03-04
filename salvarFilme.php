<?php
// salvarFilme.php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';

    if (!empty($nome) && !empty($descricao)) {
        $stmt = $conn->prepare("INSERT INTO filmes (nome, descricao) VALUES (?, ?)");
        $stmt->bind_param("ss", $nome, $descricao);
        $stmt->execute();
        $stmt->close();
    }
}

header("Location: filmes.php");
exit;
?>