<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../conexao.php'; // Verifique o caminho para 'conexao.php'

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $idusuario = (int)$data['id'];

        $sql = "DELETE FROM usuario WHERE idusuario = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param('i', $idusuario);

            if ($stmt->execute()) {
                if ($stmt->affected_rows > 0) {
                    $response['success'] = true;
                    $response['message'] = 'Registro de usuário excluído com sucesso.';
                } else {
                    $response['message'] = 'Nenhum registro de usuário encontrado com o ID fornecido.';
                }
            } else {
                $response['message'] = 'Erro ao executar a exclusão: ' . $stmt->error;
            }
            $stmt->close();
        } else {
            $response['message'] = 'Erro na preparação da declaração SQL: ' . $conn->error;
        }
    } else {
        $response['message'] = 'ID do usuário não fornecido para exclusão.';
    }
} else {
    $response['message'] = 'Método de requisição inválido. Espera-se um método POST para exclusão.';
}

echo json_encode($response);
?>