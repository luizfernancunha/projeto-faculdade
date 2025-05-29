<?php
// ATENÇÃO: Ativar exibição de erros para depuração. REMOVA EM PRODUÇÃO!
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclui o arquivo de conexão. O caminho aqui é relativo a 'pacientecadastro.php'.
// Se 'conexao.php' estiver na mesma pasta 'odio', use "conexao.php".
include("conexao.php");

// Define o tipo de conteúdo como texto simples para que o JavaScript possa interpretar facilmente a resposta
header('Content-Type: text/plain');

// Verifica se a conexão com o banco de dados foi estabelecida
if (!$conexao) {
    // Ecoamos o erro com um prefixo específico para o JavaScript
    echo "error:Erro na conexão com o banco de dados: " . mysqli_connect_error();
    exit(); // Para a execução
}

// Verifica se a requisição é POST (se o formulário foi realmente enviado)
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Recebendo os dados do formulário com o operador null coalesce (??)
    $nome = $_POST["nome"] ?? null;
    $datanascimento = $_POST["data"] ?? null;
    $genero = $_POST["genero"] ?? null;
    $altura = $_POST["altura"] ?? null;
    $peso = $_POST["peso"] ?? null;
    $niveldeatividade = $_POST["nivel"] ?? null;
    $objetivo = $_POST["objetivo"] ?? null;

    // Validações essenciais dos campos (opcional, mas recomendado)
    if (empty($nome) || empty($datanascimento) || empty($genero) || empty($altura) || empty($peso) || empty($niveldeatividade) || empty($objetivo)) {
        echo "error:Todos os campos obrigatórios devem ser preenchidos.";
        mysqli_close($conexao);
        exit();
    }

    // PREPARED STATEMENTS - ESSENCIAL PARA SEGURANÇA E CORREÇÃO DE ERROS DE SINTAXE SQL
    $sql = "INSERT INTO paciente (nome, datanascimento, genero, altura, peso, niveldeatividade, objetivo)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    if ($stmt = mysqli_prepare($conexao, $sql)) {
        // Vinculando os parâmetros.
        // 's' = string (para nome, datanascimento, genero, niveldeatividade, objetivo)
        // 'd' = double/float (para altura, peso). Se suas colunas forem INT, use 'i'.
        // Os campos ENUM, DATE e VARCHAR são sempre 's' (string).
        mysqli_stmt_bind_param($stmt, "sssddss", $nome, $datanascimento, $genero, $altura, $peso, $niveldeatividade, $objetivo);

        if (mysqli_stmt_execute($stmt)) {
            // Ecoa mensagem de sucesso com prefixo
            echo "success:Usuário cadastrado com sucesso!";
        } else {
            // Ecoa mensagem de erro com prefixo
            echo "error:Erro ao cadastrar usuário: " . mysqli_stmt_error($stmt);
        }
        mysqli_stmt_close($stmt); // Fecha a declaração preparada
    } else {
        // Ecoa mensagem de erro se a preparação da consulta falhar
        echo "error:Erro na preparação da consulta: " . mysqli_error($conexao);
    }

} else {
    // Se a página for acessada diretamente sem POST (sem envio de formulário)
    echo "error:Por favor, envie o formulário de cadastro.";
}

mysqli_close($conexao); // Fecha a conexão com o banco de dados após o uso
?>