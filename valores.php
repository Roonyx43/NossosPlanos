<?php
include('db.php'); // Inclua seu arquivo de configuração do banco de dados

// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $valor = $_POST['valor'];

    // Verifica se o valor está dentro da faixa
    if ($valor >= 1 && $valor <= 200) {
        // Verifica se já existe um registro para o usuário
        $sql = "SELECT * FROM caixinha WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Atualiza o valor para o usuário existente
            $sql = "UPDATE caixinha SET valor = ? WHERE usuario = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $valor, $usuario);
            $stmt->execute();
        } else {
            // Insere um novo registro
            $sql = "INSERT INTO caixinha (usuario, valor) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $usuario, $valor);
            $stmt->execute();
        }

        // Responder para a requisição AJAX
        echo 'success';
    }
}
?>
