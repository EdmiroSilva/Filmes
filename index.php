<!DOCTYPE HTML>
<html>

<head>
    <title>Filmes</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body id="top">
    <section id="banner">
        <div class="inner">
            <header>
                <h1>
                    <?php
                    if (isset($_GET["nome"])) {
                        echo 'Resultados para "' . $_GET["nome"] . '"';
                    }
                    ?>
                </h1>
                <p class="bold">Todas as estreias e os titulos mais marcantes da atualidade com os seus trailers e
                    sinopses.</p>
            </header>

            <a href="#main" class="more">Saber mais</a>
        </div>
    </section>

    <div id="pesquisa">
        <form action="index.php" method="get">
            <div class="centrado">
                <div class="titulo">Pesquisa:</div>
                <div class="campo">
                    <input type="text" name="nome" placeholder="Nome do filme a pesquisar">
                </div>
                <div class="acao">
                    <button><i class="icon fa-search"></i></button>
                </div>

            </div>
        </form>
    </div>

    <div id="main">
        <div class="inner">
            <!-- Caixas -->
            <div class="thumbnails">
                <?php

                $conexao = mysqli_connect("localhost", "formab5_user", "P4ssword", "formab5_bd_remota");
                $comandoLeitura = "SELECT * FROM filmes";

                if (isset($_GET["nome"])) {
                    $textoPesquisa = mysqli_real_escape_string($conexao, $_GET["nome"]);
                    $comandoLeitura .= " WHERE titulo LIKE '%$textoPesquisa%'";
                }
                $comandoLeitura .= " ORDER BY titulo";

                $resultado = mysqli_query($conexao, $comandoLeitura);

                if (mysqli_num_rows($resultado) > 0) {
                    while ($linha = mysqli_fetch_array($resultado)) {
                ?>
                <div class="box">
                    <img src="posters/<?= $linha["imagem"] ?>" class="image fit" alt="" />
                    <div class="inner">
                        <h3><?= $linha["titulo"] ?></h3>
                        <p class="sinopse"><?= $linha["sinopse"] ?></p>
                        <a href="<?= $linha["trailer"] ?>" class="button fit"
                            data-poptrox="youtube, 800x400">Trailer</a>
                    </div>
                </div>
                <?php
                    }
                } else {
                    echo "<p><b>Não há resultados para a tua pesquisa.<b></p>";
                }
                ?>
            </div>
        </div>
    </div>



    <footer id="footer">
        <div class="inner">
            <h2>Foco</h2>
            <p>Procuramos sempre trazer títulos que sejam novidade ou que marquem o espectador pela positiva. Se achar
                que faltam titulos nesta lista contacte-nos por qualquer um dos meios fornecidos</p>

            <ul class="icons">
                <li><a href="#" class="icon fa-twitter"><span class="label">Twitter</span></a></li>
                <li><a href="#" class="icon fa-facebook"><span class="label">Facebook</span></a></li>
                <li><a href="#" class="icon fa-instagram"><span class="label">Instagram</span></a></li>
                <li><a href="#" class="icon fa-envelope"><span class="label">Email</span></a></li>
            </ul>

        </div>
    </footer>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/jquery.scrolly.min.js"></script>
    <script src="assets/js/jquery.poptrox.min.js"></script>
    <script src="assets/js/skel.min.js"></script>
    <script src="assets/js/util.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>