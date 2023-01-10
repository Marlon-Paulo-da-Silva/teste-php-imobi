<?php
session_start();
require_once "../Models/Imoveis/Controller/ImoveisController.php";
$controller = new ImoveisController();
?>
<!doctype html>
<html lang="pt-br">
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
        <a class="navbar-brand" href="<?=getenv("ROOT")?>">
        <!-- <img src="https://www.imobibrasil.com.br/imagens/logo.png" alt=""
                                                      class="d-inline-block align-text-top"> -->
                                                    </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="<?=getenv("ROOT") . "pages/formulario.php"?>">Criar Anuncio</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<div class="container">

<?php

    if(isset($_SESSION['error'])){
        echo "<div class='alert alert-danger' role='alert'>"
          .$_SESSION["error"].
        "</div>";
    }
    session_destroy();
    $imoveis = $controller->listImovel();

    if(count($imoveis) > 0){
        foreach ($imoveis as $imovel) {

            if (isset($imovel['name']) && isset($imovel['email']))  {

                $publication = "";
                $hasImage = "";
                $description = isset($imovel['description']) && !empty($imovel['description']) ? "<p class='card-text'>{$imovel['description']}</p>" : '';
                $title = isset($imovel['title']) && !empty($imovel['title']) ? "<h3 class='card-text'>{$imovel['title']}</h3>" : '';
                $address = isset($imovel['fullAddress']) && !empty($imovel['fullAddress']) ? "<p class='card-text'>{$imovel['fullAddress']}</p>" : "";
                $price = isset($imovel['price']) && !empty($imovel['price']) ? "<p class='card-text'>VALOR: R$ {$imovel['price']}</p>" : "";
                if(isset($imovel['image']) && !empty($imovel['image'])){
                    $extension = explode(".",$imovel['image']);
                    $extension = end($extension);

                    if(in_array($extension, ["jpeg","jpg","png"])){
                        $hasImage =  "<img src='".getenv("ROOT"). $imovel['image'] ."' class='card-img-bottom'>";
                    }else{
                        $hasImage =  "<a href='" .getenv("ROOT"). $imovel['image'] . "' class='btn btn-primary mb-3'>Download</a>";
                    }

                }

                if(isset($imovel['createdAt']) && !empty($imovel['createdAt'])){
                    $date = strtotime($imovel['createdAt']);
                    $publication = "<p class='card-text'><small class='text-muted'>Publicado: ". date("d/m/Y H:i:s",$date)."</small></p>";
                }


                $template = file_get_contents(__DIR__ . "./cards.php");

                $dados = [
                    "name" => $imovel['name'],
                    "email" => $imovel['email'],
                    "description" => $description,
                    "address" => $address,
                    "publication" => $publication,
                    "price" => $price,
                    "title" => $title,
                    "updateURL" => getenv("ROOT"). "pages/formulario.php?id=" . $imovel['id'],
                    "deleteURL" => getenv("ROOT"). "pages/delete.php?id=" . $imovel['id'],
                    "image" => $hasImage
                ];
                foreach ($dados as $key => $val){
                    $template = str_replace('{{'. $key .'}}', $val, $template);
                }

                echo $template;

            }

        }
    }else{
        echo "<div class='alert alert-primary' role='alert'>Nenhum anúncio feito ainda!</div>";
    }

?>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-pprn3073KE6tl6bjs2QrFaJGz5/SUsLqktiwsUTF55Jfv3qYSDhgCecCxMW52nD2"
        crossorigin="anonymous"></script>
</body>
</html>



