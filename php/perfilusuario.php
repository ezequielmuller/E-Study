

<!doctype html>
<html lang="pt-BR">

<head>
    <title>E-Study 2024</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="../css/perfilusuario.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Vollkorn:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">

        <link rel="preconnect" href="https://fonts.googleapis.com"> 
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Chau+Philomene+One:ital@0;1&display=swap" rel="stylesheet">

        

</head>

<body>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />

    <center>
        <div class="container">

            <table id="table">
                <th>
                <td>
                    <img id='imgperfil' src="../img/imgperfil.png">
                </td>
                <td>
                    <p><a href="feed.php">Voltar ao Feed</a></p>
                    <h2 id="titulo">Perfil</h2>
                    <form action="php/login.php">
                        <label for="nome">Nome</label>
                        <?php
                            session_start();
                            include 'tabelacadastro.php'; 
                            if (isset($_SESSION['nomeu'])) {
                                $nomeu = $_SESSION['nomeu'];
                            } else {
                                // Redireciona para a página de login se não houver sessão
                                header('location:login.php');
                                exit();
                            }

                            // Query para buscar os dados do banco de dados
                            $sqlUsuario = "SELECT Nome FROM Usuario WHERE NomeUsuario = '$nomeu'";
                            $result = mysqli_query($con, $sqlUsuario);

                            if ($result) {
                                // Iterar pelos resultados e exibir os dados
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<div>' . htmlspecialchars($row['Nome']) . '</div>';
                                }
                            } else {
                                // Mensagem de erro caso a consulta falhe
                                echo 'Erro ao buscar os dados: ' . mysqli_error($con);
                            }

                            mysqli_close($con);
                        ?>
                        <label for="nomeusuario">Nome de Usuário</label>
                        <?php
                            
                             include 'tabelacadastro.php';
                            // Query para buscar os dados do banco de dados
                            $sqlUsuario = "SELECT NomeUsuario FROM Usuario WHERE NomeUsuario = '$nomeu'";
                            $result = mysqli_query($con, $sqlUsuario);

                            if ($result) {
                                // Iterar pelos resultados e exibir os dados
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<div>' . htmlspecialchars($row['NomeUsuario']) . '</div>';
                                }
                            } else {
                                // Mensagem de erro caso a consulta falhe
                                echo 'Erro ao buscar os dados: ' . mysqli_error($con);
                            }

                            mysqli_close($con);
                        ?>
                </td>
                </th>
            </table>

        </div>
    </center>


</body>
<script src="js/script.js" type="text/javascript"></script>

</html>