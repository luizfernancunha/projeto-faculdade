<?php
// Define o tipo de conteúdo como JSON
header('Content-Type: application/json');

// Inicia a sessão PHP (necessário para armazenar informações de login)
session_start();

// Verifica se a requisição é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Inclui o arquivo de conexão com o banco de dados
    require_once 'conexaologin.php'; // Certifique-se de que este caminho está correto

    // Obtém o email e a senha do formulário
    $email = $_POST['email'] ?? '';
    $senha_digitada = $_POST['password'] ?? ''; // Senha em texto puro digitada pelo usuário

    // Validação básica de entrada
    if (empty($email) || empty($senha_digitada)) {
        echo json_encode(['success' => false, 'message' => 'Por favor, preencha todos os campos.']);
        exit();
    }

    try {
        // Prepara a consulta para buscar o usuário pelo email
        $stmt = $conn->prepare("SELECT id, nome, email, senha FROM registro WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        // Verifica se um usuário foi encontrado
        if ($stmt->rowCount() > 0) {
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verifica a senha digitada com a senha hashed armazenada no banco de dados
            if (password_verify($senha_digitada, $usuario['senha'])) {
                // Senha correta, login bem-sucedido

                // Armazena informações do usuário na sessão
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['user_name'] = $usuario['nome'];
                $_SESSION['user_email'] = $usuario['email'];

                echo json_encode(['success' => true, 'message' => 'Login realizado com sucesso!', 'redirect' => 'paciente.html']);
                // Você pode mudar 'paciente.html' para a página que deseja redirecionar o usuário após o login
            } else {
                // Senha incorreta
                echo json_encode(['success' => false, 'message' => 'Email ou senha inválidos.']);
            }
        } else {
            // Usuário não encontrado
            echo json_encode(['success' => false, 'message' => 'Email ou senha inválidos.']);
        }

    } catch (PDOException $e) {
        // Registra a exceção PDO em um log (para depuração, não para o usuário)
        error_log("Erro de PDO no login: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'Ocorreu um erro inesperado. Tente novamente mais tarde.']);
    }

    // Fecha a conexão com o banco de dados
    $conn = null;

} else {
    // Se a requisição não for POST
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
}
?>