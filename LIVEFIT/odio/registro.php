<?php
header('Content-Type: application/json');
require_once 'conexaologin.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha_plana = $_POST['password'] ?? '';

    if (empty($nome) || empty($email) || empty($senha_plana)) {
        echo json_encode(['success' => false, 'message' => 'Todos os campos são obrigatórios.']);
        exit();
    }

    $senha_hashed = password_hash($senha_plana, PASSWORD_DEFAULT);

    try {
        // Alterado de 'usuarios' para 'registro'
        $stmt_check = $conn->prepare("SELECT id FROM registro WHERE email = :email");
        $stmt_check->bindParam(':email', $email);
        $stmt_check->execute();

        if ($stmt_check->rowCount() > 0) {
            echo json_encode(['success' => false, 'message' => 'Este e-mail já está registrado.']);
            exit();
        }

        // Alterado de 'usuarios' para 'registro'
        $stmt = $conn->prepare("INSERT INTO registro (nome, email, senha) VALUES (:nome, :email, :senha)");

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha_hashed);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Registro realizado com sucesso!']);
        } else {
            error_log("Erro ao registrar usuário: " . implode(":", $stmt->errorInfo()));
            echo json_encode(['success' => false, 'message' => 'Erro ao registrar usuário. Tente novamente mais tarde.']);
        }

    } catch (PDOException $e) {
        // Para depuração TEMPORÁRIA: Mostre a mensagem de erro PDO
        echo json_encode(['success' => false, 'message' => 'Erro interno do servidor: ' . $e->getMessage()]);
        // Mantenha o log de erros também para auditoria
        error_log("PDO Exception: " . $e->getMessage());
    } finally { // Use finally para garantir que a conexão seja fechada
        $conn = null;
    }

} else {
    echo json_encode(['success' => false, 'message' => 'Método de requisição inválido.']);
}
?>