<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="../style/callculadora.css">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <title>Calculadora de IMC</title>
</head>
<body>

<header>
    <nav id="navbar">
        <i class="fa-solid fa-dumbbell" id="nav-logo">LIVE FIT</i>
        <ul id="nav-list">
            <li class="nav-item"><a href="index.php">Início</a></li>
            <li class="nav-item"><a href="../html/calculadora.php">Cálculo</a></li>
            <li class="nav-item"><a href="../html/paciente.php">Paciente</a></li>
            <li class="nav-item "><a href="../html/avaliacao.php">Avaliação</a></li> 
            <li><button class="btn-default"><a href="../html/login.php">Login</a></button></li>
        </ul>
    </nav>
</header>

<main id="container">
    <section id="img">
        <img src="../Imgs-site/call.jpg" alt="Personal Trainer">
    </section>

    <section id="calculator">
        <form id="form">
            <h1 id="title">
                Calculadora - IMC
            </h1>

            <div class="input-box">
                <label for="gender">
                    Sexo
                </label>
                <div class="input-field">
                    <i class="fa-solid fa-venus-mars"></i>
                    <select id="gender" name="gender" required>
                        <option value="" disabled selected>Selecione</option>
                        <option value="male">Masculino</option>
                        <option value="female">Feminino</option>
                    </select>
                </div>
            </div>

            <div class="input-box">
                <label for="age">
                    Idade
                </label>
                <div class="input-field">
                    <i class="fa-solid fa-calendar-days"></i>
                    <input type="number" id="age" name="age" placeholder="Ex: 25" min="1" max="120" required>
                </div>
            </div>

            <div class="input-box">
                <label for="weight">
                    Peso em kg
                </label>
                <div class="input-field">
                    <i class="fa-solid fa-weight-hanging"></i>
                    <input type="number" id="weight" name="weight" step="0.01" required>
                    <span>
                        Kg
                    </span>
                </div>
            </div>

            <div class="input-box">
                <label for="height">
                    Altura em metros
                </label>
                <div class="input-field">
                    <i class="fa-solid fa-ruler"></i>
                    <input type="number" step="0.01" id="height" name="height" required>
                    <span>
                        m
                    </span>
                </div>
            </div>
            
            <div class="input-box">
                <label for="activity">
                    Atividade
                </label>
                <div class="input-field">
                    <i class="fa-solid fa-running"></i> 
                    <select id="activity" name="activity" required>
                        <option value="sedentary" selected>Sedentário (trabalho de escritório)</option>
                        <option value="light">Exercício leve (1-2 dias/semana)</option> 
                        <option value="moderate">Exercício moderado (3-5 dias/semana)</option>
                        <option value="heavy">Exercício pesado (6-7 dias/semana)</option>
                        <option value="athlete">Atleta (2x por dia)</option>
                    </select>
                </div>
            </div>
            
            <button id="calculate">
                Calcular
            </button>
        </form>    
        
        <div id="infos" class="hidden">
            <div id="result">
                <div id="bmi">
                    <span id="value"></span>
                    <span>Seu IMC</span>
                </div>
                <div id="description">
                    <span></span>
                </div>    
            </div>

            <div id="more_info">
                <a href="https://mundoeducacao.uol.com.br/saude-bem-estar/imc.htm" target="_blank">
                    Mais informações sobre o IMC
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                </a>
            </div>
        </div>    
    </section>
</main>
<script src="../js/calculadora.js"></script>
</body>
</html>