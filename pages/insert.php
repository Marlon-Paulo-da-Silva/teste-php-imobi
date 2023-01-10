<?php
session_start();

require_once "../Models/Imoveis/Controller/ImoveisController.php";

$controller = new ImoveisController();

$file = $_FILES['image'];
$params = $_POST;
if(!$file['error']){


    $dirUpload = __DIR__ . "/../uploads";

    if(!is_dir($dirUpload)){
        mkdir($dirUpload);
    }

    $extension = explode(".",$file['name']);
    $extension = end($extension);

    $data = date('Ymdhis');
    $rand = rand(1000,99999);

    $imageName = "{$data}{$rand}.{$extension}";
    if(move_uploaded_file($file['tmp_name'],$dirUpload . DIRECTORY_SEPARATOR . $imageName)){
        $params['image'] = "uploads/" . $imageName;
    }
}

if(isset($_GET['id']) && (int)$_GET['id']> 0){
    $params['id'] = (int)$_GET['id'];
    $response = $controller->create($params);
}

if(!isset($_GET['id'])){
    $response = $controller->create($params);
}

if(!isset($_SESSION['error'])){
    header("Location: " . getenv('ROOT') . 'pages/home.php');
}

if(isset($_SESSION['error'])){
    header("Location: " . getenv('ROOT') . 'pages/formulario.php');
    
}





