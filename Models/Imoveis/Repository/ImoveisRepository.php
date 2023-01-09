<?php

include __DIR__ . "../../../../ConnectionPDO.php";

class ImoveisRepository{

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

    public function selectImoveis($id = 0){
        try {

            if((int)$id === 0){
                $sql = "SELECT 
                            im.id,
                            im.title,
                            im.name,
                            im.email,
                            im.description,
                            im.fullAddress,
                            im.price,
                            im.createdAt,
                            me.localImage as image
                        FROM
                            imoveis AS im
                                LEFT JOIN
                            medias AS me ON (im.id = me.idImovel)
                        WHERE
                            ativo = 1 ORDER BY im.id DESC;";
            }else{
                $sql = "SELECT 
                        id, title, name, email, description, fullAddress, price, createdAt
                    FROM
                        imoveis WHERE id = :id;";
            }

            $stmt = $this->conn->prepare($sql);

            if((int)$id > 0){
                $stmt->bindValue(':id', (int)$id,\PDO::PARAM_INT);
            }

            $stmt->execute();

            if((int)$id === 0){
                return $stmt->fetchAll(\PDO::FETCH_ASSOC);
            }

            return $stmt->fetch(\PDO::FETCH_ASSOC);

        } catch (Exception $ex) {
            throw new Exception($ex->getMessage());
        }

    }


    public function verifyExistImage($idImovel){

        if((int)$idImovel === 0){ return [];}

        $sql = "SELECT 
                    id, idImovel, imageName, localImage, createdAt
                FROM
                    medias
                WHERE
                    idImovel = :idIMovel;";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':idIMovel', (int)$idImovel,\PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);

    }


}