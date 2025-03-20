<?php
$host = "localhost";
$user = "root";
$pass = "&reCH1m";
$bd = "estudy";

$mysqli = new mysqli($host, $user, $pass, $bd);

/* Checando a conexão */
if ($mysqli -> connect_errno){
    echo "Não conectou:  " . $mysqli->connect_error;
    exit();
}

