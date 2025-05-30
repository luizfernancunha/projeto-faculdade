<?php
// Initialize a message variable
$message = ''; // Ensure $message is always defined

if(isset($_POST['submit'])){
    // Include database connection
    // Assumes conexao.php is in the parent directory of 'html', i.e., directly under 'lifefit'
    // Path: lifefit/conexao.php
    include_once '../conexao.php';

    // Get form data using null coalescing operator for safety
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $feedback_message = $_POST['message'] ?? '';
    $submission_date = date('Y-m-d H:i:s'); // Capture submission time

    // Validate data (basic example)
    if (!empty($name) && !empty($email) && !empty($feedback_message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        if ($conn) { // Check if $conn (database connection from conexao.php) is valid
            // SQL: CREATE TABLE feedback (id INT AUTO_INCREMENT PRIMARY KEY, name VARCHAR(255), email VARCHAR(255), message TEXT, submission_date DATETIME);
            $stmt = $conn->prepare("INSERT INTO feedback (name, email, message, submission_date) VALUES (?, ?, ?, ?)");
            
            if ($stmt) {
                $stmt->bind_param("ssss", $name, $email, $feedback_message, $submission_date);
                if($stmt->execute()){
                    $message = "Feedback enviado com sucesso!";
                    // Clear form fields after successful submission by not repopulating them
                    $_POST = array(); 
                } else {
                    $message = "Erro ao enviar feedback: " . htmlspecialchars($stmt->error);
                }
                $stmt->close();
            } else {
                $message = "Erro ao preparar a declaração SQL: " . htmlspecialchars($conn->error);
            }
            $conn->close();
        } else {
            $message = "Erro: Não foi possível conectar ao banco de dados. Verifique o arquivo conexao.php.";
        }
    } else {
        $error_details = [];
        if (empty($name)) $error_details[] = "Nome é obrigatório.";
        if (empty($email)) $error_details[] = "Email é obrigatório.";
        elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) $error_details[] = "Formato de email inválido.";
        if (empty($feedback_message)) $error_details[] = "Mensagem é obrigatória.";
        
        $message = "Por favor, corrija os seguintes erros: " . implode(" ", $error_details);
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback - LIVE FIT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
    <link rel="stylesheet" href="../style/feedback.css"> </head>
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
        <form id="formFeedback" action="feedback.php" method="POST"> <?php if(!empty($message)): ?>
                <div class="response-message <?php echo (strpos(strtolower($message), 'sucesso') !== false) ? 'success' : 'error'; ?>">
                    <?php echo htmlspecialchars($message); // Sanitize output ?>
                </div>
            <?php endif; ?>

            <div class="form-group">
                <label for="name">Nome:</label>
                <input type="text" id="name" name="name" placeholder="Seu nome" required 
                       value="<?php echo isset($_POST['name']) && strpos(strtolower($message), 'sucesso') === false ? htmlspecialchars($_POST['name']) : ''; ?>" />
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" placeholder="exemplo@gmail.com" required
                       value="<?php echo isset($_POST['email']) && strpos(strtolower($message), 'sucesso') === false ? htmlspecialchars($_POST['email']) : ''; ?>" />
            </div>

            <div class="form-group">
                <label for="message">Mensagem:</label>
                <textarea id="message" name="message" placeholder="Diga-nos o que você pensa..." rows="6" required><?php 
                    echo isset($_POST['message']) && strpos(strtolower($message), 'sucesso') === false ? htmlspecialchars($_POST['message']) : ''; 
                ?></textarea>
            </div>

            <div class="form-actions">
                <button type="submit" name="submit" class="btn-enviar">Enviar Feedback</button>
            </div>
        </form>
    </main>

</body>
</html>