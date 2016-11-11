<?php

class whiteUser{
    //private $sessid;
    private $access_token;
    private $tag1;
    private $tag2;

    public function __construct(){
        $this->access_token = isset( $_SESSION['access_token'] ) ? $_SESSION['access_token'] : '';
        $this->tag1 = isset( $_SESSION['tag1'] ) ? $_SESSION['tag1'] : '';
        $this->tag2 = isset( $_SESSION['tag2'] ) ? $_SESSION['tag2'] : '';
    }

    public function set_access_token($access_token){
        $this->access_token = $_SESSION['access_token'] = $access_token;
    }
    public function set_tag1($tag){
        $this->tag1 = $_SESSION['tag1'] = $tag;
    }
    public function set_tag2($tag){
        $this->tag2 = $_SESSION['tag2'] = $tag;
    }

    public function get_access_token(){
        return $this->access_token;
    }
    public function get_tag1(){
        return $this->tag1;
    }
    public function get_tag2(){
        return $this->tag2;
    }
}