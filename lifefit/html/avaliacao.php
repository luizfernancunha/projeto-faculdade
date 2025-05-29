<?php
if(isset($_POST['submit'])){




/*
print_r('Name: ' .  $_POST['nome']);
print_r('<br>');
print_r('data_avaliacao: '.   $_POST['data_avaliacao']);
print_r('<br>');
print_r('plano_exercicios: '. $_POST['plano_exercicios']);
print_r('<br>');
print_r('plano_alimentar:'.  $_POST['plano_alimentar']);
print_r('<br>');


}*/

include_once '../conexao.php';

$nome = $_POST['nome'];
$dataAvalicao = $_POST['dataavaliacao']; 
$PlanoExercicios = $_POST['planoexercicios'] ;
$PlanoAlimentar = $_POST['planoalimentar'] ;



$result = mysqli_query($conn ,"INSERT INTO avaliacao(nome,dataAvaliacao,PlanoExercicios ,PlanoAlimentar ) VALUES ('$nome', '$dataAvalicao','$PlanoExercicios',  '$PlanoAlimentar')");

}











?>






















<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliação do Paciente - LIVE FIT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="../style/avaliacao.css"> </head>
<body>
    <header>
        <nav id="navbar">
            <i class="fa-solid fa-dumbbell" id="nav-logo">LIVE FIT</i>
            <ul id="nav-list">
                <li class="nav-item"><a href="index.php">Inicio</a></li>
                <li class="nav-item"><a href="../html/calculadora.php">Cálculo</a></li>
                <li class="nav-item"><a href="../html/paciente.php">Paciente</a></li>
                <li class="nav-item"><a href="../html/avaliacao.php">Avaliação</a></li> 
                <li><button class="btn-default"><a href="../html/login.php">Login</a></button></li>
            </ul>
        </nav>
    </header>

    <main class="evaluation-container">
        <h1>Avaliação do Paciente</h1>
        <form id="formAvaliacao" action="../html/avaliacao.php" method="POST">
            <div class="form-group">


                <label for="nomePaciente">Nome do Paciente:</label>
                <input type="text" id="nomePaciente" name="nome" required>
            </div>




            <div class="form-group">
                <label for="dataAvaliacao">Data da Avaliação:</label>
                <input type="date" id="dataAvaliacao" name="dataavaliacao" required>
            </div>






            <div class="form-group">
                <label for="planoExercicios">O que o paciente deve fazer (Plano de Exercícios):</label>
                <textarea id="planoExercicios" name="planoexercicios" rows="6" placeholder="Descreva o plano de exercícios..."></textarea>
            </div>





            <div class="form-group">
                <label for="planoAlimentar">O que o paciente deve comer (Plano Alimentar):</label>
                <textarea id="planoAlimentar" name="planoalimentar" rows="6" placeholder="Descreva o plano alimentar..."></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn-salvar">Salvar Avaliação</button>
                <button type="button" class="btn-limpar" onclick="document.getElementById('formAvaliacao').reset()">Limpar Campos</button>
            </div>
            <div id="responseMessage" style="margin-top: 15px; text-align: center; font-weight: bold;"></div>
        </form>
    </main>

    </body>
</html>