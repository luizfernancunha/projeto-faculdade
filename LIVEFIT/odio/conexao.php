<?php
    $servidor ="localhost";
    $usuario = "root";
    $senha = ""; // Sua senha, se houver
    $dbname = "cadastropaciente";

    $conexao = mysqli_connect($servidor, $usuario, $senha, $dbname);

    // Este bloco de erro pode ser removido se o tratamento principal for no pacientecadastro.php
    /*
    if (!$conexao) {
        die("Houve um erro na conexão (do conexao.php): " . mysqli_connect_error());
    } else {
        // echo "Conexão bem-sucedida! (do conexao.php)"; // Descomente para testar a conexão diretamente
    }
    */
?>