<?php 

class User { 
    public function __construct(){

    }

    public function countLikes(){ 
        $mysql = mysqli_connect("localhost","root","","sdk_demo");
        $query = "SELECT * FROM `blog` WHERE 1 AND COUNT likes";
        $result = mysqli_query($mysql,$query);
        return $result;
    }
}


$user = new User(); 
$user->countLikes();