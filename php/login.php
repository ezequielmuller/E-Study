<?php
session_start(); // Inicia a sessão

include 'tabelacadastro.php';

$nomeu = $_GET["nomeu"];
$senha = $_GET["senha"];

$sql = "SELECT * FROM usuario WHERE NomeUsuario = '$nomeu' AND Senha = '$senha'";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows($result) > 0) { // Verifica se a consulta retornou alguma linha
    // Login OK
    $_SESSION['nomeu'] = $nomeu; // Salva o nome de usuário na sessão
    $idUsuario = "SELECT idUsuario FROM usuario WHERE NomeUsuario = '$nomeu' AND Senha = '$senha'";
    $_SESSION['idUsuario'] = $idUsuario;
    //puxa o id de usuario
    
    //$_SESSION[];


    mysqli_close($con);
    header('location:feed.php'); // Redireciona para o feed
    exit();
} else {
    // Login com erro
    mysqli_close($con);
    header('location:../tela_cadastro.html'); // Redireciona para a tela de cadastro
    exit();
}
?>
