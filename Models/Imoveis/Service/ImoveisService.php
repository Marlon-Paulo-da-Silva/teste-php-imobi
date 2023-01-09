<?php

class ImoveisService
{
    protected $conn;

    public function __construct($connection = null)
    {
        if(is_null($connection)){
            $this->conn = ConnectionPDO::getInstance();
        } else {
            $this->conn = $connection;
        }

        $this->conn->query('SET names utf8');
    }

    public function create(ImoveisModel $model){
        try {

            $sql = "INSERT INTO imoveis (title,name,email,description,fullAddress,price,createdAt,ativo) 
                    VALUES (:title,:name,:email,:description,:fullAddress,:price,:createdAt,1)";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':title', $model->getTitle(),\PDO::PARAM_STR);
            $stmt->bindValue(':name', $model->getName(),\PDO::PARAM_STR);
            $stmt->bindValue(':email', $model->getEmail(),\PDO::PARAM_STR);
            $stmt->bindValue(':description', $model->getDescription(),\PDO::PARAM_STR);
            $stmt->bindValue(':fullAddress', $model->getFullAddress(),\PDO::PARAM_STR);
            $stmt->bindValue(':price', (double)$model->getPrice(),\PDO::PARAM_STR);
            $stmt->bindValue(':createdAt', $model->getCreatedAt(),\PDO::PARAM_STR);


            $stmt->execute();

            return $this->conn->lastInsertId();
        }
        catch (Exception $ex) {
            throw new $ex($ex->getMessage());
        }
    }

    public function update(ImoveisModel $model){
        try {

            $sql = "UPDATE imoveis SET title = :title,name = :name,email = :email,description = :description,fullAddress = :fullAddress,price= :price WHERE id = :id;";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':title', $model->getTitle(),\PDO::PARAM_STR);
            $stmt->bindValue(':name', $model->getName(),\PDO::PARAM_STR);
            $stmt->bindValue(':email', $model->getEmail(),\PDO::PARAM_STR);
            $stmt->bindValue(':description', $model->getDescription(),\PDO::PARAM_STR);
            $stmt->bindValue(':fullAddress', $model->getFullAddress(),\PDO::PARAM_STR);
            $stmt->bindValue(':price', (double)$model->getPrice(),\PDO::PARAM_STR);
            $stmt->bindValue(':id', (int)$model->getId(),\PDO::PARAM_INT);

            return $stmt->execute();
        }
        catch (Exception $ex) {
            throw new $ex($ex->getMessage());
        }
    }

    public function insertImage(ImoveisModel $model){
        try {

            $sql = "INSERT INTO medias (idImovel, imageName, localImage, createdAt) 
                    VALUES (:idImovel, :imageName, :localImage, :createdAt)";

            $stmt = $this->conn->prepare($sql);

            $imageName = explode("/",$model->getImage());
            $imageName = end($imageName);

            $stmt->bindValue(':idImovel', $model->getId(),\PDO::PARAM_INT);
            $stmt->bindValue(':imageName', $imageName,\PDO::PARAM_STR);
            $stmt->bindValue(':localImage', $model->getImage(),\PDO::PARAM_STR);
            $stmt->bindValue(':createdAt', $model->getCreatedAt(),\PDO::PARAM_STR);


            $stmt->execute();

            return $this->conn->lastInsertId();
        }
        catch (Exception $ex) {
            throw new $ex($ex->getMessage());
        }
    }

    public function updateImage(ImoveisModel $model){
        try {

            $sql = "UPDATE medias SET imageName = :imageName, localImage = :localImage, createdAt = :createdAt WHERE idImovel = :idImovel;";

            $stmt = $this->conn->prepare($sql);

            $imageName = explode("/",$model->getImage());
            $imageName = end($imageName);

            $stmt->bindValue(':idImovel', $model->getId(),\PDO::PARAM_INT);
            $stmt->bindValue(':imageName', $imageName,\PDO::PARAM_STR);
            $stmt->bindValue(':localImage', $model->getImage(),\PDO::PARAM_STR);
            $stmt->bindValue(':createdAt', $model->getCreatedAt(),\PDO::PARAM_STR);


            $stmt->execute();

            return $this->conn->lastInsertId();
        }
        catch (Exception $ex) {
            throw new $ex($ex->getMessage());
        }
    }

    public function delete($id){
        try {

            $sql = "UPDATE imoveis SET ativo = 0 WHERE id = :id";

            $stmt = $this->conn->prepare($sql);

            $stmt->bindValue(':id', (int)$id,\PDO::PARAM_INT);


            return $stmt->execute();
        }
        catch (Exception $ex) {
            throw new $ex($ex->getMessage());
        }
    }


}