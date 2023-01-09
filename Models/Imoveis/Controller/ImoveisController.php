<?php

include __DIR__ . "../../Repository/ImoveisRepository.php";
include __DIR__ . "../../Service/ImoveisService.php";
include __DIR__ . "../../Model/ImoveisModel.php";

date_default_timezone_set('America/Sao_Paulo');

class ImoveisController
{

    public function create($params){

        $isSave = false;

        try {

            $params = array_map(function ($param){
                return trim($param);
            },$params);

            $model = self::setModel($params);

            if(empty($model->getName())){
                $_SESSION["errors"]["name"] = "O nome é obrigatório.";
            }

            if(empty($model->getEmail())){
                $_SESSION["errors"]["email"] = "O email é obrigatório.";
            }

            if( isset($_SESSION["errors"]) && count( $_SESSION["errors"]) > 0){

                if((int)$model->getId() > 0){
                    header("Location: " . getenv('ROOT') . 'pages/formulario.php?id='. (int)$model->getId());
                }else{
                    header("Location: " . getenv('ROOT') . 'pages/formulario.php');
                }
            }

            $serviceImovel = new ImoveisService();

            if((int)$model->getId() > 0){

                $isSave = $serviceImovel->update($model);

                if(!empty($model->getImage()) && $isSave){
                    $verificaImagem = (new ImoveisRepository())->verifyExistImage((int)$model->getId());

                    if(isset($verificaImagem['id']) && !empty($verificaImagem['localImage'])){
                        $isSave = $serviceImovel->updateImage($model);
                    }else{
                        $isSave = $serviceImovel->insertImage($model);
                    }

                }

            }

            if((int)$model->getId() === 0){

                $id = $serviceImovel->create($model);
                $isSave = (int)$id > 0;

                if(!empty($model->getImage()) && (int)$id > 0){
                    $model->setId((int)$id);
                    $isSave = $serviceImovel->insertImage($model);
                }

            }

            return $isSave;

        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }
    }


    public function listImovel($id = 0){

        $modelRepository = new ImoveisRepository();
        return $modelRepository->selectImoveis((int)$id);
    }

    public function delete($id){

        $serviceImovel = new ImoveisService();

        return $serviceImovel->delete($id);

    }

    private static function setModel($params){

        $model = new ImoveisModel();

        $model->setId(isset($params['id']) && (int)$params['id'] > 0 ? (int)$params['id'] : 0);
        $model->setEmail(isset($params['email']) && !empty($params['email']) ? $params['email'] : null);
        $model->setName(isset($params['name']) && !empty($params['name']) ? $params['name'] : null);
        $model->setDescription(isset($params['description']) && !empty($params['description']) ? $params['description'] : null);
        $model->setFullAddress(isset($params['address']) && !empty($params['address']) ? $params['address'] : null);
        $model->setPrice(isset($params['price']) && (double)($params['price']) > 0 ? (double)$params['price'] : null);
        $model->setTitle(isset($params['title']) && !empty($params['title']) ? $params['title'] : null);
        $model->setEmail(isset($params['email']) && !empty($params['email']) ? $params['email'] : null);
        $model->setImage(isset($params['image']) && !empty($params['image']) ? $params['image'] : null);
        $model->setCreatedAt(date("Y-m-d H:i:s"));

        return $model;
    }

}