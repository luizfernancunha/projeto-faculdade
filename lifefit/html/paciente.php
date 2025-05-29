<?php
if(isset($_POST['submit'])){



/*
print_r('Name: ' .  $_POST['nome']);
print_r('<br>');
print_r('Date: '.   $_POST['data']);
print_r('<br>');
print_r('Altura: '. $_POST['altura']);
print_r('<br>');
print_r('Peso'.  $_POST['peso']);
print_r('<br>');
print_r('Nivel: '. $_POST['nivel']);
print_r('<br>');
print_r('Objetivo: '. $_POST['objetivo']);

}*/
include_once '../conexao.php';

$nome = $_POST['nome'];
$datanacimento = $_POST['data']; 
$altura = $_POST['altura']; 
$peso = $_POST['peso']; 
$nivel_de_atividade = $_POST['nivel']; 
$objetivo = $_POST['objetivo'];


$result =mysqli_query($conn ,"INSERT INTO paciente(nome, datanacimento, altura, peso, nivel_de_atividade, objetivo) VALUES ('$nome', '$datanacimento', $altura, $peso, '$nivel_de_atividade', '$objetivo')");






}








?>





























<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Paciente</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
    <link rel="stylesheet" href="../style/paciente.css">
    <script src="https://kit.fontawesome.com/SEU_CODIGO_DO_KIT_FONT_AWESOME.js" crossorigin="anonymous"></script>
</head>

<body>
    <header>
        <nav id="navbar">
            <i class="fa-solid fa-dumbbell" id="nav-logo">LIVE FIT</i>
            <ul id="nav-list">
                <li class="nav-item "><a href="index.php">Inicio</a></li>
                <li class="nav-item"><a href="../html/calculadora.php">Cálculo</a></li>
                <li class="nav-item"><a href="../html/paciente.php">Paciente</a></li>
                <li class="nav-item "><a href="../html/avaliacao.php">Avaliação</a></li> 
                <li><button class="btn-default"><a href="../html/login.php">Login</a></button></li>
            </ul>
        </nav>
    </header>

    <div class="container">
        <div class="form-image">
            <img src="../Imgs-site/undraw_fitness-stats_uk0g.svg" alt="Fitness Stats">
        </div>
        <div class="form">
            <form id="cadastroPacienteForm" action="paciente.php" method="post">
                <div class="form-header">
                    <div class="title">
                        <h1>Paciente</h1>
                    </div>
                </div>

                <div class="input-group">
                    <div class="input-box">
                        <label for="inputNome">Nome:</label>
                        <input type="text" name="nome" id="inputNome" placeholder="Digite seu nome" required>
                    </div>

                    <div class="input-box">
                        <label for="inputDataNascimento">Data de nascimento:</label>
                        <input type="date" name="data" id="inputDataNascimento" placeholder="Coloque sua data de nascimento" required>
                    </div>

                    <div class="input-box">
                        <label for="selectGenero">Gênero:</label>
                        <select id="selectGenero" name="genero" required>
                            <option value="">Selecione</option>
                            <option value="Masculino">Masculino</option>
                            <option value="Feminino">Feminino</option>
                            <option value="Outro">Outro</option>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="inputAltura">Altura (cm):</label>
                        <input type="number" name="altura" id="inputAltura" placeholder="Digite sua altura em cm" step="0.01" required>
                    </div>

                    <div class="input-box">
                        <label for="inputPeso">Peso (kg):</label>
                        <input type="number" id="inputPeso" name="peso" placeholder="Digite seu peso em kg" step="0.1" required>
                    </div>

                    <div class="input-box">
                        <label for="selectNivelAtividade">Nível de Atividade:</label>
                        <select id="selectNivelAtividade" name="nivel" required>
                            <option value="">Selecione</option>
                            <option value="Sedentario">Sedentário (Pouco ou nenhum exercício)</option>
                            <option value="Levemente Ativo">Levemente Ativo (Exercício leve/esportes 1-3 dias/semana)</option>
                            <option value="Moderadamente Ativo">Moderadamente Ativo (Exercício moderado/esportes 3-5 dias/semana)</option>
                            <option value="Muito Ativo">Muito Ativo (Exercício intenso/esportes 6-7 dias/semana)</option>
                            <option value="Extremamente Ativo">Extremamente Ativo (Exercício muito intenso diário/trabalho físico)</option>
                        </select>
                    </div>

                    <div class="input-box">
                        <label for="selectObjetivo">Objetivo:</label>
                        <select id="selectObjetivo" name="objetivo" required>
                            <option value="">Selecione</option>
                            <option value="Emagrecer">Emagrecer</option>
                            <option value="Ganhar Massa Muscular">Ganhar Massa Muscular</option>
                            <option value="Bem-estar Geral">Bem-estar Geral</option>
                            <option value="Melhora de Condicionamento">Melhora de Condicionamento</option>
                            <option value="Manutenção de Peso">Manutenção de Peso</option>
                            <option value="Reabilitação (Pós-lesão)">Reabilitação (Pós-lesão)</option>
                        </select>
                    </div>
                </div>

               <div class="continue-button">
                    <button type="submit" name="submit">Cadastrar Paciente</button>
                </div>
                <div id="responseMessage" style="margin-top: 20px; text-align: center; font-weight: bold; color: red;"></div>
            </form>
        </div>
    </div>

</body>

</html>