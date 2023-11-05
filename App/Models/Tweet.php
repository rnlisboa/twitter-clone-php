<?php

namespace App\Models;
use MF\Model\Model;

class Tweet extends Model{
    private $id;
    private $id_usuario;
    private $tweet;
    private $data;

    public function __get($attr){
        return $this->$attr;
    }
    public function __set($attr, $value){
        $this->$attr = $value;
    }

    public function salvar():Tweet{
        $query = "insert into tweet(id_usuario,tweet)values(:id_usuario, :tweet)";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id_usuario", $this->__get('id_usuario'));
        $stmt->bindValue(":tweet", $this->__get('tweet'));
        $stmt->execute();
        return $this;
    }

    public function delete(){
        $query = "delete from tweet where id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue("id", $this->__get("id"));
        $stmt->execute();
    }

    public function getAll():array{
        $query = "
        select
            t.id, t.id_usuario, u.nome, t.tweet, DATE_FORMAT(t.data, '%d/%m/%Y %H:%i') as data
        from 
            tweet as t
            left join usuario as u on (t.id_usuario = u.id)
        where 
            id_usuario = :id_usuario
        order by
            t.data desc";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':id_usuario', $this->__get('id_usuario'));
        $stmt->execute();   

        $tweets = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        return $tweets;
    }
}

?>