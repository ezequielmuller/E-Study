<?php
include 'tabelacadastro.php';

include("conexao.php");

if (isset($_FILES['arquivo'])) {
    $arquivo = $_FILES['arquivo'];

    if ($arquivo['size'] > 2097152)
        die('Arquivo muito grande! Máximo 2MB');

    if ($arquivo['error'])
        die('Falha ao enviar o arquivo!');

    $pasta = "arquivos/";
    $nomeDoArquivo = $arquivo['name'];
    $novoNomedoArquivo = uniqid();
    $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));

    if ($extensao != "jpg" && $extensao != "png")
        die("Tipo de arquivo não aceito");

    $path = $pasta . $novoNomedoArquivo . "." . $extensao;

    $deu_certo = move_uploaded_file($arquivo["tmp_name"], $path);

    if ($deu_certo) {
        $nomeDoArquivo = $mysqli->real_escape_string($nomeDoArquivo);
        $path = $mysqli->real_escape_string($path);

        $query = "INSERT INTO arquivo (nome, path) VALUES ('$nomeDoArquivo', '$path')";
        $mysqli->query($query) or die($mysqli->error);

        echo "<p>Arquivo enviado com sucesso!</p>";
    } else {
        echo "<p>Falha ao enviar o arquivo!</p>";
    }

}




$busca = isset($_GET['busca']) ? $_GET['busca'] : '';

session_start();
            if (isset($_SESSION['nomeu'])) {
                $nomeu = $_SESSION['nomeu'];
                
            } else {
                header('location:login.php');
                exit();
            }
            if (isset($_SESSION['idUsuario'])) {
            $idUsuario = $_SESSION['idUsuario'];
            }else {
                header('location:login.php');
                exit();
            }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Inserção de Texto
    if (isset($_POST["Texto"]) && !empty($_POST["Texto"])) {
        $Texto = mysqli_real_escape_string($con, $_POST["Texto"]);
        $sql = "INSERT INTO ObjetoDeEstudo (Texto) VALUES (?)";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, 's', $Texto);

        if (mysqli_stmt_execute($stmt)) {
            echo "Texto inserido com sucesso!";
        } else {
            echo "Erro ao inserir texto: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
        header('location:feed.php');
        exit();
    }

    // Inserção de Imagem
    // if (isset($_FILES['arquivo']) && $_FILES['arquivo']['error'] == 0) {
    //     $extensaoArquivo = pathinfo($_FILES['arquivo']['name'], PATHINFO_EXTENSION);
    //     $permitidas = ['jpg', 'jpeg', 'png', 'gif']; // Extensões permitidas
    //     if (in_array(strtolower($extensaoArquivo), $permitidas)) {
    //         $nomeArquivo = uniqid('imagem_', true) . '.' . $extensaoArquivo;
    //         $tipoArquivo = $_FILES['arquivo']['type'];
    //         $conteudoArquivo = file_get_contents($_FILES['arquivo']['tmp_name']);

    //         $sql = "INSERT INTO Arquivo (Nome, Tipo, _Arquivo) VALUES (?, ?, ?)";
    //         $stmt = mysqli_prepare($con, $sql);
    //         mysqli_stmt_bind_param($stmt, 'ssb', $nomeArquivo, $tipoArquivo, $conteudoArquivo);
    //         mysqli_stmt_send_long_data($stmt, 2, $conteudoArquivo);

    //         if (mysqli_stmt_execute($stmt)) {
    //             echo "Imagem enviada e salva com sucesso!";
    //         } else {
    //             echo "Erro ao salvar a imagem: " . mysqli_error($con);
    //         }

    //         mysqli_stmt_close($stmt);
    //     } else {
    //         echo "Formato de arquivo não suportado. Por favor, envie apenas imagens.";
    //     }
    // }
}

// Busca no Feed (texto e imagens)
$searchTerm = '%' . mysqli_real_escape_string($con, $busca) . '%';

// Buscar textos
$sqlTexto = "SELECT Texto FROM ObjetoDeEstudo WHERE Texto LIKE ?";
$stmtTexto = mysqli_prepare($con, $sqlTexto);
mysqli_stmt_bind_param($stmtTexto, 's', $searchTerm);
mysqli_stmt_execute($stmtTexto);
$resultTexto = mysqli_stmt_get_result($stmtTexto);

// // Buscar imagens
// $sqlImagem = "SELECT Nome, Tipo, _Arquivo FROM Arquivo WHERE Nome LIKE ?";
// $stmtImagem = mysqli_prepare($con, $sqlImagem);
// mysqli_stmt_bind_param($stmtImagem, 's', $searchTerm);
// mysqli_stmt_execute($stmtImagem);
// $resultImagem = mysqli_stmt_get_result($stmtImagem);



$sql_query = $mysqli->query("SELECT * FROM arquivo") or die($mysql->error);

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
            <?php
            // session_start();
            // if (isset($_SESSION['nomeu'])) {
            //     $nomeu = $_SESSION['nomeu'];
            //     $idUsuario = $_SESSION['idUsuario'];
            // } else {
            //     header('location:login.php');
            //     exit();
            // }
            echo '<div id="UsuarioLogado">@' . $nomeu . '<button type="button" class="botaoColEsq">
                <a href="perfilusuario.php"><i class="fas fa-user"></i> Acessar Perfil</a>
                </button></div>';
            ?>
            <img src="../img/logomarca.png" />
            <button type="submit" class="botaoColEsq" id='abrirtela'>Escrever</button>
            <button type="button" class="botaoColEsq" id='sairsistema'><a href="../index.html">Sair do
                    Sistema</a></button><br>
        </div>

       <!-- Coluna Central (Feed) -->
<div class="col-lg-6">
    <header>
        <div class="navbar">
            <div class="logo"><img class="logoheader" src="../img/logotipo.png" alt="Logotipo"></div>
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
            // Exibindo uma postagem fixa de exemplo
            echo '<div class="mensagem">
                    <div class="cabecalhomensagem"><i>@ProfDario</i></div>
                    Esta é uma postagem teste
                    <img style="border-radius: 10px" src="../img/paisagem.jpg" alt="Paisagem">
                  </div>';

            
                  if (mysqli_num_rows($resultTexto) > 0) {
                    while ($row = mysqli_fetch_assoc($resultTexto)) {
                        $texto = isset($row['Texto']) ? htmlspecialchars($row['Texto']) : "Texto não disponível";
                
                        // Verificar se há upload associado
                        $arquivo = mysqli_num_rows($sql_query) > 0 ? $sql_query->fetch_assoc() : null;
                        $path = isset($arquivo['path']) ? $arquivo['path'] : null;
                        $nomeArquivo = isset($arquivo['Nome']) ? $arquivo['Nome'] : null;
                        $dataUpload = isset($arquivo['data_upload']) ? date("d/m/Y H:i", strtotime($arquivo['data_upload'])) : null;
                
                        // Exibir a mensagem com ou sem upload
                        echo '<div class="mensagem">
                                <div class="cabecalhomensagem"><i>@' . $nomeu . '</i></div>
                                ' . $texto;
                
                        if ($arquivo) {
                            echo '<img height="" src="' . $path . '" alt="Arquivo">
                                  <div>Arquivo: ' . $nomeArquivo . '</div>
                                  <div>Data de envio: ' . $dataUpload . '</div>';
                        }
                
                        echo '</div>';
                    }
                } else {
                    echo "Nenhum resultado encontrado.";
                }
                
            
                  // Exibir textos do banco de dados
            // if (mysqli_num_rows($resultTexto) > 0) {
            //     while ($row = mysqli_fetch_assoc($resultTexto)) {
            //         echo '<div class="mensagem">
            //                 <div class="cabecalhomensagem"><i>@' . $nomeu . '</i></div>
            //                 ' . htmlspecialchars($row['Texto']) . '
            //               </div>';
            //     }
            // }

            // Exibir arquivos (se houver)
            // if (mysqli_num_rows($sql_query) > 0) {
            //     while ($arquivo = $sql_query->fetch_assoc()) {
            //         echo '<div class="mensagem">
            //                 <div class="cabecalhomensagem"><i>@' . $nomeu . '</i></div>
            //                 <img height="" src="' . $arquivo['path'] . '" alt="Arquivo">
            //                 <div>Arquivo: ' . $arquivo['Nome'] . '</div>
            //                 <div>Data de envio: ' . date("d/m/Y H:i", strtotime($arquivo['data_upload'])) . '</div>
            //               </div>';
            //     }
            // }
            ?>
        </div>
    </main>
</div>


        <!-- Coluna Direita -->
        <div class="col-lg-3 coluna-lateral">
            <img src="../img/logomarca.png" />
        </div>
    </div>

    <!-- Formulário Oculto como Modal -->
    <div id="fundoModal"
        style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 1200;">
        <div id="formularioEscrever"
            style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #52559fe0; padding: 20px; width: 80%; max-width: 600px; border-radius: 8px;">

            <button type="button" id="fecharFormulario" style="position: absolute; top: 10px; right: 10px;">X</button>

           
            <form enctype="multipart/form-data" id="ObjetoDeEstudo" action="" method="POST">
                <p><input type="text" id="Texto" name="Texto" placeholder="Digite seu texto aqui" required>
                   <input id="arquivos" type="file" name="arquivo" accept="image/*" style='width: 300px'>
                   <button type="submit" class="botaoColEsq" >Enviar</button>
                </p><br>
                <div id="mensagemErro" class="invalid-feedback" style="color: red;"></div>
            </form>
        
        
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        crossorigin="anonymous"></script>
    <script src="../js/Vfeed.js" type="text/javascript"></script>
</body>

</html>