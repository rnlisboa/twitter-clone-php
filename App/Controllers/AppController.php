<?php

namespace App\Controllers;

//os recursos do miniframework
use MF\Controller\Action;
use MF\Model\Container;

class AppController extends Action {

    private function is_auth_user():bool {
        session_start();
        if(!empty($_SESSION["id"]) && !empty($_SESSION["nome"])){
            return true;
        } else {
            return false;
        }
    }
    public function timeline(){
        $is_user_auth = $this->is_auth_user();
        if($is_user_auth){
            $tweet = Container::getModel("Tweet");
            $tweet->__set('id_usuario', $_SESSION['id']);
            $tweets = $tweet->getAll();
            $this->view->tweets = $tweets;
            $this->render("timeline");
        }else{
            header("Location: /");
        }
    }

    public function tweet(){
        $is_user_auth = $this->is_auth_user();
        if($is_user_auth){
            $tweet = Container::getModel("Tweet");
            $tweet->__set("tweet", $_POST['tweet']);
            $tweet->__set("id_usuario", $_SESSION['id']);
            $tweet->salvar();
            header("Location: /timeline");
            } else{
                header("Location: /");
            }
    }

    public function delete_tweet(){
        $tweet = Container::getModel("Tweet");
      
        $tweet->__set("id", $_POST['id']);
        $tweet->delete();
        header("Location: /timeline");
    }
}

?>