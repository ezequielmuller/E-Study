<?php
$con = mysqli_connect("localhost", "root", "&reCH1m", "estudy");//servidor, usuario, senha, banco


if(mysqli_connect_error()){
    echo 'Erro na conexão com BD: '.mysqli_connect_error();
}

?>