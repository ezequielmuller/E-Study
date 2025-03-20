    <?php
    include 'tabelacadastro.php';
    ?> 
            <!-- Nome: -->
            <?php
            echo $_GET["nome"];
            $nome = $_GET["nome"];
            ?> <br>
        

            <!-- Sobrenome: -->
            <?php
            echo $_GET["snome"];
            $snome = $_GET["snome"];
            ?> <br>
        

            <!-- Nome de Usuário: -->
            <?php
            echo $_GET["nomeu"];
            $nomeu = $_GET["nomeu"];
            ?> <br>
        

            <!-- Telefone:-->
            <?php 
            echo $_GET["telefone"];
            $telefone = $_GET["telefone"];
            ?> <br>
        
     
            <!-- Email: -->
            <?php
            echo $_GET["email"];
            $email = $_GET["email"];
            ?> <br>
        

            <!-- Senha: -->
            <?php
            echo $_GET["senha"];
            $senha = $_GET["senha"];
            ?> <br>
        

        <?php
        $sql = "INSERT INTO Usuario (Nome, Sobrenome, NomeUsuario, Telefone, Email, Senha) 
        VALUES ('$nome' ,'$snome', '$nomeu','$telefone', '$email', '$senha')";
        mysqli_query($con, $sql);
        if (mysqli_error($con)) {
            echo mysqli_error($con);
        } else {
            echo "Usuario cadastrado com sucesso!";
        }
        mysqli_close($con);

        header('location:../index.html'); //chama a tela de login do sistema
        ?>
    