<?php
include 'tabelacadastro.php';

$busca = isset($_GET['busca']) ? $_GET['busca'] : '';




// Busca no Feed (texto e imagens)
$searchTerm = '%' . mysqli_real_escape_string($con, $busca) . '%';



//Buscar nome do usuario
$sqlNome = "SELECT Nome, NomeUsuario FROM Usuario WHERE Nome LIKE ?";
$stmtNome = mysqli_prepare($con, $sqlNome);
mysqli_stmt_bind_param($stmtNome, 's', $searchTerm);
mysqli_stmt_execute($stmtNome);
$resultNome = mysqli_stmt_get_result($stmtNome);


?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <title>Feed</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/feed.css">
</head>

<body>
    <div class='row'>
        <!-- Coluna Esquerda -->
        <div class="col-lg-3 coluna-lateral">
            <img src="../img/logomarca.png" />
        </div>

        <!-- Coluna Central (Feed) -->
        <div class="col-lg-6">
            <header>
                <div class="navbar">
                    <div class="logo"><img class="logoheader" src="../img/logotipo.png"></div>
                    <div class="search-bar">
                        <form action='feed.php' method='GET'>
                            <input id='busca' type="text" name="busca" placeholder="Ex: @gemeosshowdebola"
                                value="<?php echo htmlspecialchars($busca); ?>">
                            <button type='submit' id="bpesquisar"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </header>
            <main>
                <div id="feed-container">
                    <?php
                    session_start();
                    if (isset($_SESSION['nomeu'])) {
                        $nomeu = $_SESSION['nomeu'];
                    } else {
                        header('location:login.php');
                        exit();
                    }

                    // Exibir textos
                    
                    while ($row = mysqli_fetch_assoc($resultNome)) {
                        echo '<div class="mensagem">';
                        echo '<div class="cabecalhomensagem"><i>@' . htmlspecialchars($row['NomeUsuario']) . '</i></div>';
                        echo htmlspecialchars($row['Nome']);
                        echo '</div>';
                    }


                    mysqli_stmt_close($stmtNome);
                    mysqli_close($con);
                    ?>
                </div>
            </main>
        </div>

        <!-- Coluna Direita -->
        <div class="col-lg-3 coluna-lateral">
            <img src="../img/logomarca.png" />
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/Vfeed.js" type="text/javascript"></script>
</body>

</html>