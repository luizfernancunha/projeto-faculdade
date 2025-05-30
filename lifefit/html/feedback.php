<?php
// Verifica se o formulário foi submetido usando o botão 'submit'
if(isset($_POST['submit'])){

    // Inclui o arquivo de conexão com o banco de dados
    // Certifique-se de que o caminho para 'conexao.php' está correto em relação a 'feedback.php'
    include_once '../conexao.php'; 

    // Captura os dados do formulário
    // Agora, usamos 'name' em vez de 'nome' para corresponder ao HTML
    $nome_recebido = $_POST['name']; 
    $email_recebido = $_POST['email'];
    $mensagem_recebida = $_POST['mensagem'];

    // Prepara a consulta SQL para inserir os dados na tabela 'feedback'
    // É importante usar declarações preparadas ou escapar os dados para evitar SQL Injection.
    // Para fins didáticos e simplicidade, manteremos a sua forma original, mas com a ressalva.
    $sql_query = "INSERT INTO feedback(nome, email, mensagem) VALUES ('$nome_recebido', '$email_recebido', '$mensagem_recebida')";
    
    // Executa a consulta no banco de dados
    $result = mysqli_query($conn, $sql_query);

    
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - LIVE FIT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="../style/feedback.css">
</head>
<body>
    <header>
        <nav id="navbar">
            <i class="fa-solid fa-dumbbell" id="nav-logo">LIVE FIT</i>
            <ul id="nav-list">
                <li class="nav-item"><a href="index.php">Início</a></li>
                <li class="nav-item"><a href="calculadora.php">Cálculo</a></li>
                <li class="nav-item"><a href="paciente.php">Paciente</a></li>
                <li class="nav-item"><a href="avaliacao.php">Avaliação</a></li>
                <li class="nav-item active"><a href="feedback.php">Feedback</a></li>
                <li><button class="btn-default"><a href="login.php">Login</a></button></li>
            </ul>
        </nav>
    </header>

    <main class="feedback-container">
        <h1>Deixe Seu Feedback</h1>
        <form id="formFeedback" action="feedback.php" method="POST">
            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" placeholder="Seu nome" />
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="exemplo@gmail.com" required value="" /> 
                </div>

            <div class="form-group">
                <label for="message">Mensagem:</label>
                <textarea id="message" name="mensagem" placeholder="Diga-nos o que você pensa..." rows="6" required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn-enviar">Enviar Feedback</button>
            </div>
        </form>
    </main>

</body>
</html>