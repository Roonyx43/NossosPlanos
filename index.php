<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nossos Planos</title>
    <link rel="stylesheet" href="style.css">
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
    <button class="valuesModal" onclick="abrirModal()">Sejam bem vindos!</button>
    <div class="overlay" id="overlay"></div>
    <div id="valuesModal" class="values-modal">
        <h2>Olá familia linda!</h2>
        <p>Este site é mais do que um simples espaço nosso, é um registro da nossa jornada, que esta sendo incrível para mim, saiba que eu te amo muito, e vou continuar te amando cada dia mais! E para nossos filhos que um dia verão isso, saibam: cada momento aqui representa o esforço, o amor e a dedicação que colocamos para construir um futuro melhor para vocês. Seu pai sempre se esforçou muito, e vai continuar se esforçando, para que vocês tenham uma vida cheia de felicidade. <br><br><h3>PS</h3><p>Respeitem a mamãe! Ela é brava!</p>
        </p>
        <button onclick="fecharModal()" class="closeModal">Fechar</button>
    </div>
    <main>
        <div class="carousel-container">
            <div class="carousel">
                <div class="slides">
                    <div class="slide"><img src="assets/euegabb.jpg" alt="Descrição da imagem 1"></div>
                    <div class="slide"><img src="assets/euegabb2.jpg" alt="Descrição da imagem 2"></div>
                    <div class="slide"><img src="assets/euegabb3.jpg" alt="Descrição da imagem 3"></div>
                </div>
            </div>
        </div>
    </main>

    <script src="script.js" defer></script>
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
</body>
</html>
