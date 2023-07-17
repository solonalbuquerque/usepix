<?php

namespace SmartSolucoes\Core;

use PDO;

class Model
{
    static $PDO;
    static $banco;

    static function banco()
    {
        global $banco;
        return self::$banco;
    }

    static function PDO()
    {
        global $pdo;
        if (!self::$PDO) {
            try {
                $dsn = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHARSET;
                self::$PDO = new PDO($dsn, DB_USER, DB_PASS);
                self::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$PDO->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
                self::$PDO->exec("SET time_zone='".date('P')."';");
            } catch (PDOException $e) {
                // Normally, we would log this
                die('Connection error: ' . $e->getMessage() . '<br/>');
            }
        }
        return self::$PDO;
    }

    public function create($table, $fields, $exception = [])
    {
        $PDO = $this->PDO();
        $set = [];
        $setValue = [];
        foreach ($fields as $field => $value) {
            if(!in_array($field,$exception)){
                $set[] = $field . ' = :' . $field;
                $setValue[':'.$field] = $value;
            }
        }
        if(@$_SESSION['id_user']) $setAdmin = "id_update_user = '" . (@$_SESSION['id_user'] ? @$_SESSION['id_user'] : 0) . "', ";
        $sql = "INSERT INTO " . $table . " SET " . @$setAdmin . implode(', ',$set);
        $query = $PDO->prepare($sql);
        if($query->execute($setValue)) {
            $return = $PDO->lastInsertId();
        } else {
            $return = false;
        }
        return $return;
    }

    public function save($table, $fields, $exception = [], $where=[])
    {
        global $banco, $id_usuario;
        $dados = [];
        foreach ($fields as $field => $value) {
            if(!in_array($field,$exception)){
                $dados[$field] = ($value=="" || $value=="NULL") ? NULL : $value;
            }
        }
        if($id_usuario!="") {
            $dados['id_update_user'] = $id_usuario;
        }
        if($where==[]) {
            $banco->where("id", $dados['id']);
        } else {
            foreach ($where as $field => $value) {
                if(!in_array($field,$exception) && $value!='NULL' && $value!=""){
                    $banco->where($field, $value);
                }
            }
        }

        if ($banco->update ($table, $dados)) {
            return true;
        } else {
            //return 'update failed: ' . $banco->getLastError();
            return false;
        }
    
    }

    public function delete($table, $field = false, $value = false, $limit = 1)
    {
        try {
            $PDO = self::PDO();
            $where = $limit = '';
            if(is_array($field)) {
                foreach ($field as $key => $item){
                    $where .= " AND " . $item . " = '" . $value[$key] . "'";
                }
            } elseif($field) {
                $where = "AND " . $field . " = '" . $value . "'";
            }
            if(is_numeric($limit)) $limit = "LIMIT $limit";
            if($where) {
                $sql = "DELETE FROM " . $table . " WHERE 1=1 $where $limit";
                $query = $PDO->prepare($sql);
                $query->execute();
            }
        } catch (\PDOException $Exception) {
            echo '<script>if(!alert("Existem outros itens que dependem desse para funcionar.\rApague primeiro eles para depois realizar essa ação.")) { window.history.back(); }</script>';
            die();
        }
    }

    public function status($table, $id, $status)
    {
        $sql = "UPDATE " . $table . " SET status = " . $status . " WHERE id = :id LIMIT 1";
        $query = $this->PDO()->prepare($sql);
        $query->execute([':id' => $id]);
    }

    public function all($table, $order = 'id', $field = false, $value = false)
    {

        $where = '';
        if(is_array($field)) {
            foreach ($field as $key => $item){
                $where .= " AND " . $item . " = '" . $value[$key] . "'";
            }
        } elseif($field) {
            $where = "AND " . $field . " = '" . $value . "'";
        }
        $sql = "SELECT * FROM " . $table . " WHERE 1=1 " . $where . " ORDER BY status DESC, " . $order;
        $query = $this->PDO()->prepare($sql);
        $query->execute();
        return $query->fetchAll();
    }

    public function find($table, $valor, $campo='id')
    {
        $sql = "SELECT * FROM " . $table . " WHERE $campo = :$campo LIMIT 1";
        $query = $this->PDO()->prepare($sql);
        $query->execute([':'.$campo => $valor]);
        return $query->fetch();
    }
  
  	public function findapi($table, $id)
    {
        $sql = "SELECT * FROM " . $table . " WHERE tokenid = :id LIMIT 1";
        $query = $this->PDO()->prepare($sql);
        $query->execute([':id' => $id]);
        return $query->fetch();
    }

    public function defineOrder($table, $id, $order, $id_categoria=false, $id_cadastro=false){

        $where = '';
        if($id_categoria) $where .= " AND id_categoria = '" . $id_categoria . "'";
        if($id_cadastro) $where .= " AND id_cadastro = '" . $id_cadastro . "'";

        $PDO = $this->PDO();
        $PDO->query("SET @a := -1; UPDATE " . $table . " SET ordem = @a := @a+1 WHERE 1=1 " . $where . " AND id <> " . $id . " AND (ordem <= " . $order . " OR ordem IS NULL) ORDER BY ordem;");
        $PDO->query("SET @a := " . $order . "; UPDATE " . $table . " SET ordem = @a := @a+1 WHERE 1=1 " . $where . " AND id <> " . $id . " AND (ordem >= " . $order . " OR ordem IS NULL) ORDER BY ordem;");

    }

    public function count($item, $table, $where)
    {
        $sql = "SELECT count($item) as qtd FROM " . $table . " WHERE $where LIMIT 1";
        $query = $this->PDO()->query($sql);
        return (int) $query->fetchColumn();
    }
    

}
