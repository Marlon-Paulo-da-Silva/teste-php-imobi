<?php
session_start();
$id = $_GET["id"];

if(isset($id) && (int)$id > 0){
    require_once "../Models/Imoveis/Controller/ImoveisController.php";
    $controller = new ImoveisController();
    $response = $controller->delete($id);

    if(!$response){
        $_SESSION["error"] = "Não foi possível excluir no momento este item";
    }

    header("Location: " . getenv('ROOT') . 'pages/home.php');
}
