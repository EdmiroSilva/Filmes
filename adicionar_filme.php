<?php
function imagemValida($tipo)
{
    $tiposValidos = array(
        'image/jpeg',
        'image/png',
        'image/pjpeg',
        'image/gif',
        'image/x-png',
        'image/bmp',
        'image/jpg'
    );

    if (in_array(strtolower($tipo), $tiposValidos)) {
        return true;
    } else {
        return false;
    }
}

$titulo = "";
$sinopse = "";
$imagem = "";
$trailer = "";

$erroTitulo = "";
$erroSinopse = "";
$erroImagem = "";
$erroTrailer = "";

if (isset($_POST["titulo"])) {
    $conexao = mysqli_connect("localhost", "formab5_user", "P4ssword", "formab5_bd_remota");

    $titulo = mysqli_real_escape_string($conexao, trim($_POST["titulo"]));
    $sinopse = mysqli_real_escape_string($conexao, trim($_POST["sinopse"]));
    $imagem = basename($_FILES['imagem']['name']);
    $trailer = mysqli_real_escape_string($conexao, trim($_POST["trailer"]));

    if (strlen($titulo) == 0) {
        $erroTitulo = "Título obrigatório.";
    }
    if (strlen($sinopse) == 0) {
        $erroSinopse = "Sinopse obrigatória.";
    }
    if (strlen($imagem) == 0 || !imagemValida($_FILES['imagem']['type'])) {
        $erroImagem = "Escolha um ficheiro do tipo imagem.";
    }
    if (strlen($trailer) == 0) {
        $erroTrailer = "Trailer obrigatório.";
    }

    if ($erroTitulo == "" && $erroSinopse == "" && $erroImagem == "" && $erroTrailer == "") {
        $caminhoDestino = "posters/$imagem";

        if (!move_uploaded_file($_FILES['imagem']['tmp_name'], $caminhoDestino)) {
            $erroImagem = "Erro a mover a imagem para o servidor";
        } else {
            $comandoLeitura = "INSERT INTO filmes (titulo, sinopse, imagem, trailer) VALUES ('$titulo', '$sinopse', '$imagem', '$trailer')";
            mysqli_query($conexao, $comandoLeitura);
            header("Location:index.php");
        }
    }
}
?>

<!DOCTYPE HTML>
<html>

<head>
    <title>Adicionar Filme</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="assets/css/main.css" />
</head>

<body id="top">
    <section id="banner">
        <div class="inner">
            <header>
                <h1>Adicionar Filme</h1>
                <p class="bold">Faça a inserção do filme colocando todas as informações dos campos abaixo</p>
            </header>
            <a href="#main" class="more">Saber mais</a>
        </div>
    </section>

    <div id="main">
        <h2 class="form-title">Novo Filme</h3>
            <form enctype="multipart/form-data" method="post" class="adicionar">
                <input type="hidden" name="MAX_FILE_SIZE" value="1500000" />
                <table>
                    <tr>
                        <td>Titulo:</td>
                        <td>
                            <input type="text" name="titulo" value="<?= $titulo ?>">
                            <span class="erro"><?= $erroTitulo ?></span>
                        </td>

                    </tr>
                    <tr>
                        <td>Sinopse:</td>
                        <td><textarea name="sinopse" cols="30" rows="10"><?= $sinopse ?></textarea>
                            <span class="erro"><?= $erroSinopse ?></span>
                        </td>

                    </tr>
                    <tr>
                        <td>Imagem:</td>
                        <td><input type="file" name="imagem" value="<?= $imagem ?>" placeholder="Nome da imagem com extensão">
                            <span class="erro"><?= $erroImagem ?></span>
                        </td>

                    </tr>
                    <tr>
                        <td>Trailer</td>
                        <td><input type="text" name="trailer" value="<?= $trailer ?>" placeholder="Link do youtube para o trailer">
                            <span class="erro"><?= $erroTrailer ?></span>
                        </td>

                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" value="Inserir"></td>
                    </tr>
                </table>
            </form>
    </div>

    <footer id="footer">
        <div class="inner">

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