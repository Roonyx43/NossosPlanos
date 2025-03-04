<?php
header("Access-Control-Allow-Origin: *");
include('db.php'); // Inclua seu arquivo de configuração do banco de dados

// Variáveis para mensagens de erro
$alertMessage = '';
$alertType = ''; // 'success' ou 'error' ou 'warning'

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $valor = $_POST['valor'];

    // Verifica se o valor está dentro da faixa
    if ($valor >= 1 && $valor <= 200) {
        // Verificar se o valor já foi inserido para o usuário
        $sql = "SELECT * FROM caixinha WHERE usuario = ? AND valor = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $usuario, $valor);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            // Se o valor já foi inserido, não salvar
            $alertMessage = 'Este valor já foi inserido.';
            $alertType = 'error'; // Tipo de mensagem: 'error'
        } else {
            // Se o valor não foi inserido, inserir no banco
            $sql = "INSERT INTO caixinha (usuario, valor) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $usuario, $valor);
            $stmt->execute();

            $alertMessage = 'Valor salvo com sucesso!';
            $alertType = 'success'; // Tipo de mensagem: 'success'
        }
    } else {
        $alertMessage = 'Por favor, insira um valor entre 1 e 200 reais.';
        $alertType = 'warning'; // Tipo de mensagem: 'warning'
    }
}

// Recuperar os valores inseridos para Matheus e Gabriela
$matheusValor = null;
$gabrielaValor = null;

// Matheus
$sql = "SELECT valor FROM caixinha WHERE usuario = 'Matheus' ORDER BY valor ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $matheusValor = $result->fetch_all(MYSQLI_ASSOC);
}

// Gabriela
$sql = "SELECT valor FROM caixinha WHERE usuario = 'Gabriela' ORDER BY valor ASC";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $gabrielaValor = $result->fetch_all(MYSQLI_ASSOC);
}

// Recuperar o total combinado de Matheus e Gabriela
$totalCaixinha = 0;

// Somar todos os valores de ambos os usuários
$sql = "SELECT SUM(valor) AS total FROM caixinha";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalCaixinha = $row['total'] ?? 0;
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Caixinha</title>
    <style>
        /* Estilo do Modal */
        .alert-modal {
            display: none;
            position: fixed;
            top: 20%;
            left: 50%;
            transform: translateX(-50%);
            padding: 20px;
            background-color: white;
            border-radius: 8px;
            border: 2px solid;
            z-index: 9999;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
        .alert-error {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }
        .alert-warning {
            background-color: #fff3cd;
            border-color: #ffeeba;
            color: #856404;
        }
        .alert-modal h4 {
            margin: 0;
        }

        /* Estilo do Modal de Alerta */
.alert-modal {
    display: none; /* Inicialmente oculto */
    position: fixed;
    top: 20%;
    left: 50%;
    transform: translateX(-50%);
    padding: 20px;
    background-color: white;
    border-radius: 8px;
    border: 2px solid;
    z-index: 9999;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

.alert-success {
    background-color: #d4edda;
    border-color: #c3e6cb;
    color: #155724;
}

.alert-error {
    background-color: #f8d7da;
    border-color: #f5c6cb;
    color: #721c24;
}

.alert-warning {
    background-color: #fff3cd;
    border-color: #ffeeba;
    color: #856404;
}

    </style>
    <link rel="stylesheet" href="modal.css">
</head>
<body>
    <header>
        <section class="menus">
            <div class="hamburguer">
                <img src="https://img.icons8.com/?size=100&id=101311&format=png&color=000000" alt="" id="hamburgui">
            </div>
            <nav class="navbar" id="navBar">
                <a href="index.html">Inicio</a>
                <a href="contador.html">Contador</a>
                <a href="caixinha.php">Caixinha</a>
                <a href="filmes.php">Filmes e Series</a>
                
            </nav>
            <div class="logout"></div>
        </section>
    </header>
    
    <main>
        <div class="mainContainer">
            <h1>Caixinha</h1>
            <form action="caixinha.php" method="POST">
                <label for="usuario">É o Math ou a Gabb?: </label>
                <select name="usuario" id="usuario">
                    <option value="Matheus" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['usuario'] == 'Matheus') echo 'selected'; ?>>Matheus</option>
                    <option value="Gabriela" <?php if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['usuario'] == 'Gabriela') echo 'selected'; ?>>Gabriela</option>
                </select>
                <br>
                <label for="valor">Escolha o valor da caixinha (1 a 200 reais):</label>
                <input type="number" name="valor" id="valor" min="1" max="200" required value="<?php if ($_SERVER['REQUEST_METHOD'] == 'POST') echo $_POST['valor']; ?>">
                <br>
                <input type="submit" value="Salvar valor" class="salvar">
            </form>

            <button id="viewValuesBtn">Ver valores na caixinha</button>

            <!-- Modal para mostrar os valores registrados -->
            <div id="overlay" class="overlay"></div>
            <div id="valuesModal" class="values-modal">
                <h2>Valores Registrados</h2>

                <h3>Matheus:</h3>
                <ul>
                    <?php 
                    if ($matheusValor) {
                        foreach ($matheusValor as $row) {
                            echo "<li>R$ " . $row['valor'] . "</li>";
                        }
                    } else {
                        echo "<li>Nenhuma escolha feita ainda.</li>";
                    }
                    ?>
                </ul>

                <h3>Gabriela:</h3>
                <ul>
                    <?php 
                    if ($gabrielaValor) {
                        foreach ($gabrielaValor as $row) {
                            echo "<li>R$ " . $row['valor'] . "</li>";
                        }
                    } else {
                        echo "<li>Nenhuma escolha feita ainda.</li>";
                    }
                    ?>
                </ul>

                <!-- Exibir o total combinado de ambos os usuários -->
                <p class="total"><strong>Total acumulado: R$ <?php echo number_format($totalCaixinha, 2, ',', '.'); ?></strong></p>

                <button id="closeValuesModal">Fechar</button>
            </div>

            <!-- Modal para mostrar alertas -->
            <?php
            if ($alertMessage != '') {
                echo "<script>alert('$alertMessage');</script>";
            }
            ?>
        </div>
    </main>

    <script>
        // Exibe o modal com os valores registrados
        const viewValuesBtn = document.getElementById('viewValuesBtn');
        const valuesModal = document.getElementById('valuesModal');
        const closeValuesModal = document.getElementById('closeValuesModal');
        const overlay = document.getElementById('overlay');

        viewValuesBtn.addEventListener('click', function() {
            valuesModal.style.display = 'block';
            overlay.style.display = 'block'; // Torna o overlay visível
        });

        closeValuesModal.addEventListener('click', function() {
            valuesModal.style.display = 'none';
            overlay.style.display = 'none'; // Oculta o overlay
        });

        // Fechar o modal ao clicar no overlay
        overlay.addEventListener('click', function() {
            valuesModal.style.display = 'none';
            overlay.style.display = 'none'; // Oculta o overlay
        });

    </script>
    <script src="script.js"></script>
</body>
</html>
