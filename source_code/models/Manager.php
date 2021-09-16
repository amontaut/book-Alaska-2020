<?php

class Manager {
    //etabli la connexion avec la BDD
    protected function dbConnect()
    {
      
      
        $db = new PDO('mysql:host=localhost;dbname=dbs437782;charset=utf8', 'root', 'root');
        return $db;
    }
}

