<?php

namespace Entidad;

use App\Lib\Database;
use App\Lib\Response;
use App\Lib\ResponseBootgrid;

class Proceso_model{
    private $db;
    private $table = 'procesos';
    private $response;
    private $bootgrid;

    public function __construct()
    {
        $this->db = Database::StartUp();
        $this->response = new Response();
        $this->bootgrid = new ResponseBootgrid();
    }

    public function GetAll($url=false)
    {
        try {
            $result = array();
            if($url){
                $sql = sprintf("SELECT t.*, concat(%s,t.id) link FROM $this->table t", $url);
            }else{
                $sql = sprintf("SELECT t.* FROM $this->table t");
            }

            $stm = $this->db->prepare($sql);
            $stm->execute();

            $this->response->setResponse(true);
            $this->response->result = $stm->fetchAll();

            return $this->response;

        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        };
    }

    public function GetAllBootgrid($url=false)
    {
        try {
            $result = array();
            if($url){
                $sql = sprintf("SELECT t.*, concat(%s,t.id) link FROM $this->table t", $url);
            }else{
                $sql = sprintf("SELECT t.* FROM $this->table t");
            }

            $stm = $this->db->prepare($sql);
            $stm->execute();

            $this->bootgrid->setResponse($stm->fetchAll(), $stm->rowCount());

            return $this->bootgrid;

        } catch (Exception $e) {
            $this->bootgrid->setResponse(false, $e->getMessage());
            return $this->bootgrid;
        };
    }

    public function Get($id)
    {
        try {
            $result = array();

            $stm = $this->db->prepare("SELECT * FROM $this->table WHERE id = ?");
            $stm->execute(array($id));

            $this->response->setResponse(true);
            $this->response->result = $stm->fetch();

            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
            return $this->response;
        }
    }

    public function InsertOrUpdate($data){
        try {
            if (isset($data['id'])) {
                $sql = "UPDATE $this->table SET 
                            name              = ?, 
                            idmacroproceso    = ?,
                            codigo            = ?,
                            idresponsable     = ?,
                            estado            = ?
                        WHERE id = ?";

                $this->db->prepare($sql)
                    ->execute(
                        array(
                            $data['name'],
                            $data['idmacroproceso'],
                            $data['codigo'],
                            $data['idresponsable'],
                            $data['estado'],
                            $data['id']
                        )
                    );
            } else {
                $sql = "INSERT INTO $this->table
                            (name, idmacroproceso,codigo, idresponsable, estado)
                            VALUES (?,?,?, ?, ?)";

                $this->db->prepare($sql)
                    ->execute(
                        array(
                            $data['name'],
                            $data['idmacroproceso'],
                            $data['codigo'],
                            $data['idresponsable'],
                            1
                        )
                    );
            }
            $this->response->setResponse(true);
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

    public function Delete($id)
    {
        try {
            $stm = $this->db
                ->prepare("DELETE FROM $this->table WHERE id = ?");

            $stm->execute(array($id));

            $this->response->setResponse(true);
            return $this->response;
        } catch (Exception $e) {
            $this->response->setResponse(false, $e->getMessage());
        }
    }

}