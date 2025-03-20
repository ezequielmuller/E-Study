<?php
include 'tabelacadastro.php';

// Verificando se foi feita uma busca
if (isset($_GET['busca']) && !empty($_GET['busca'])) {
    // Escapar o texto para prevenir SQL Injection
    $busca = mysqli_real_escape_string($con, $_GET['busca']);

    // Realizar a busca nos campos Texto e NomeUsuario
    $sql = "SELECT Texto FROM ObjetoDeEstudo WHERE Texto LIKE ?";  // Buscar por conteúdo do texto
    $stmt = mysqli_prepare($con, $sql);
    $searchTerm = "%" . $busca . "%";  // Adicionar os wildcards do LIKE
    mysqli_stmt_bind_param($stmt, "s", $searchTerm);

    mysqli_stmt_execute($stmt);
    $resultTexto = mysqli_stmt_get_result($stmt);
    
    // Exibir resultados de texto
    if (mysqli_num_rows($resultTexto) > 0) {
        echo "<h2>Resultados para '{$busca}':</h2>";
        while ($row = mysqli_fetch_assoc($resultTexto)) {
            echo "<div class='mensagem'>" . htmlspecialchars($row['Texto']) . "</div>";
        }
    } else {
        echo "<p>Nenhum texto encontrado para sua busca.</p>";
    }
    
    // Buscar por arquivos relacionados (se necessário)
    $sqlArquivo = "SELECT Nome, Tipo, _Arquivo FROM Arquivo WHERE Nome LIKE ?";
    $stmtArquivo = mysqli_prepare($con, $sqlArquivo);
    mysqli_stmt_bind_param($stmtArquivo, "s", $searchTerm);
    mysqli_stmt_execute($stmtArquivo);
    $resultArquivo = mysqli_stmt_get_result($stmtArquivo);
    
    if (mysqli_num_rows($resultArquivo) > 0) {
        while ($row = mysqli_fetch_assoc($resultArquivo)) {
            // Exibir arquivo como imagem se for do tipo imagem
            if (strpos($row['Tipo'], 'image') !== false) {
                echo "<div class='mensagem'><img src='data:" . $row['Tipo'] . ";base64," . base64_encode($row['_Arquivo']) . "' alt='" . htmlspecialchars($row['Nome']) . "' /></div>";
            } else {
                // Exibir um link para download do arquivo
                echo "<div class='mensagem'><a href='data:" . $row['Tipo'] . ";base64," . base64_encode($row['_Arquivo']) . "' download='" . htmlspecialchars($row['Nome']) . "'>Baixar " . htmlspecialchars($row['Nome']) . "</a></div>";
            }
        }
    } else {
        echo "<p>Nenhum arquivo encontrado para sua busca.</p>";
    }

    // Fechar conexão
    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmtArquivo);
} else {
    echo "<p>Por favor, insira um termo para busca.</p>";
}

mysqli_close($con);
?>