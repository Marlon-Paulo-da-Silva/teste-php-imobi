<?php
session_start();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ImobiBrasil Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="home.php"><img src="https://www.imobibrasil.com.br/imagens/logo.png" alt=""
                                                      class="d-inline-block align-text-top"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="formulario.php">Criar Anuncio</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php

    require_once "../Models/Imoveis/Controller/ImoveisController.php";

    $controller = new ImoveisController();
    $imovel = [];

    if(isset($_GET['id']) && !empty($_GET['id'])){
        $imovel = $controller->listImovel((int)$_GET['id']);
    }

?>
<div class="container">
    <h2>Formulário de anúncio</h2>
    <form class="row g-3 needs-validation" method="POST" action="<?= !isset($_GET['id'])  ? getenv("ROOT"). "pages/insert.php" : getenv("ROOT"). "pages/insert.php?id=" . $_GET['id']?>" enctype="multipart/form-data" >
        <div class="col-6">
            <label for="title">Titulo</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= !empty($imovel['title']) ? $imovel['title'] : ''?>" placeholder="Informe o titulo do anuncio">
        </div>
        <div class="col-3">
            <label for="name" >Nome anunciante</label>
            <input type="text" required class='form-control <?=isset($_SESSION['errors']['name']) ? "is-invalid":""?>' id="name" name="name" value="<?= !empty($imovel['name']) ? $imovel['name'] : ''?>" placeholder="Informe seu nome">
            <div class="invalid-feedback">
                <?=isset($_SESSION['errors']['name']) ? $_SESSION['errors']['name'] : ""?>
            </div>
        </div>
        <div class="col-3">
            <label for="email" >Email anunciante</label>
            <input type="email" required class="form-control <?=isset($_SESSION['errors']['email']) ? "is-invalid":""?>" id="email" name="email" value="<?= !empty($imovel['email']) ? $imovel['email'] : ''?>" placeholder="Informe seu email">
            <div class="invalid-feedback">
                <?=isset($_SESSION['errors']['email']) ? $_SESSION['errors']['email'] : ""?>
            </div>
        </div>
        <div class="col-12">
            <label for="description" class="form-label">Descreva o imóvel</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= !empty($imovel['description']) ? $imovel['description'] : ''?></textarea>
        </div>
        <div class="col-8">
            <label for="address" >Endereço</label>
            <input type="text" class="form-control" id="address" name="address" value="<?= !empty($imovel['fullAddress']) ? $imovel['fullAddress'] : ''?>" placeholder="Informe o endereço">
        </div>
        <div class="col-4">
            <label for="price">Preço</label>
            <input type="number" class="form-control" id="price" name="price" value="<?= !empty($imovel['price']) ? $imovel['price'] : ''?>" placeholder="Informe o preço">
        </div>
        <div class="col-12">
            <label for="image" class="form-label">Upload de uma imagem</label>
            <input class="form-control" type="file" id="image" name="image">
        </div>
        <div class="col-auto">
            <button type="submit" class="btn btn-primary mb-3"><?= isset($imovel['id']) && (int)$imovel['id']  > 0 ? "Atualizar" : 'Anunciar'?></button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>
</html>

<?php  session_destroy();?>


