<?php
require 'db.php';

// Recupera os filmes do banco de dados
$query = "SELECT * FROM filmes ORDER BY id DESC";
$result = $conn->query($query);
$filmes = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sugestões de Filmes</title>
    <link rel="stylesheet" href="modal.css">
</head>
<body>
    <header>
        <section class="menus">
            <div class="hamburguer">
                <img src="https://img.icons8.com/?size=100&id=101311&format=png&color=000000" alt="" id="hamburgui">
            </div>
            <nav class="navbar" id="navBar">
                <a href="index.php">Inicio</a>
                <a href="contador.html">Contador</a>
                <a href="caixinha.php">Caixinha</a>
                <a href="filmes.php">Filmes e Series</a>
                
            </nav>
            <div class="logout"></div>
            
        </section>
    </header>

    <main>
        <div class="mainContainer">
            <h1>Sugestões de Filmes</h1>
            <form action="salvarFilme.php" method="POST">
                <input type="text" name="nome" placeholder="Nome do filme" required class="nomeFilme">
                <textarea name="descricao" placeholder="Descrição do filme" required class="descFilme"></textarea>
                <button type="submit" class="salvar">Salvar</button>
            </form>
            
            <div id="overlay" class="overlay"></div>
            <button onclick="abrirModal()"  class="salvar">Ver Lista de Filmes</button>
            <div id="valuesModal" class="values-modal">
                <h3>Lista de Filmes</h3>
                <ul>
                    <?php foreach ($filmes as $filme): ?>
                        <div class="linhas">
                            <li><strong style="color: goldenrod"><?= htmlspecialchars($filme['nome']) ?></strong>: <?= htmlspecialchars($filme['descricao']) ?> <br><br> <small style="color: goldenrod;">Adicionado em: <?= date("d/m/Y H:i", strtotime($filme['criado_em'])) ?></small></li>
                        </div>
                    <?php endforeach; ?>
                </ul>
                <button onclick="fecharModal()" class="closeModal">Fechar</button>
            </div>
        </div>
    </main>
    <script>
        function abrirModal() {
            document.getElementById("valuesModal").style.display = "block";
            document.getElementById("overlay").style.display = "block";
        }
        function fecharModal() {
            document.getElementById("valuesModal").style.display = "none";
            document.getElementById("overlay").style.display = "none";
        }
    </script>
    <script src="script.js"></script>
</body>
</html>


