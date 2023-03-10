<?php

//Configuração de acesso ao banco de dados
$host = "localhost";
$user = "root";
$pass = ""; 
$dbName = "";
$port = 3306;

global $hostServer, $portServer, $usernameServer, $passwordServer;

try {
    //Conexão com a porta
    $conn = new PDO("mysql:host=$host;port=$port;dbname=" . $dbName, $user, $pass);

    //Conexão sem a porta
    //$conn = new PDO("mysql:host=$host;dbname=" . $dbName, $user, $pass);

    //echo "Conexão com banco de dados realizada com sucesso!";
} catch (\PDOException $err) {
    echo "Error: Conexão com banco de dados falhou! <br> Erro gerado: " . $err->getMessage();
}