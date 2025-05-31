<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../conexao.php'; // Verifique o caminho para 'conexao.php'

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id']) && isset($data['new_password'])) {
        $idusuario = (int)$data['id'];
        $newPassword = $data['new_password'];

        // VALIDAÇÃO DA SENHA (adicione mais validações se necessário)
        if (strlen($newPassword) < 6) {
            $response['message'] = 'A nova senha deve ter no mínimo 6 caracteres.';
            echo json_encode($response);
            exit();
        }

        // REMOVIDO: password_hash() para salvar a senha em texto puro
        $senhaParaSalvar = $newPassword;

        $sql = "UPDATE usuario SET senha = ? WHERE idusuario = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            // 's' para string (senha), 'i' para inteiro (idusuario)
            $stmt->bind_param('si', $senhaParaSalvar, $idusuario);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Senha do usuário redefinida com sucesso (salva em texto puro).'; // Mensagem de aviso
                } else {
                    $response['message'] = 'Nenhum usuário encontrado com o ID fornecido ou senha já é a mesma.';
                }
            } else {
                $response['message'] = 'Erro ao executar a redefinição de senha: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = 'Erro na preparação da declaração SQL para redefinir senha: ' . $conn->error;
        }
    } else {
        $response['message'] = 'ID do usuário ou nova senha não fornecidos.';
    }
} else {
    $response['message'] = 'Método de requisição inválido. Espera-se um método POST.';
}

echo json_encode($response);
?>