<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../conexao.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $idusuario = (int)$data['id'];

        $updateFields = [];
        $params = [];
        $types = '';

        // Adiciona campos para atualização se existirem nos dados recebidos
        // APENAS NOME E EMAIL SÃO EDITÁVEIS VIA AÇÃO DE 'EDITAR'
        if (isset($data['nome'])) {
            $updateFields[] = "nome = ?";
            $params[] = $data['nome'];
            $types .= 's';
        }
        if (isset($data['email'])) {
            $updateFields[] = "email = ?";
            $params[] = $data['email'];
            $types .= 's';
        }
        // REMOVIDO: Não atualiza a senha aqui. Isso é feito no reset_password_usuario.php.

        if (!empty($updateFields)) {
            $sql = "UPDATE usuario SET " . implode(', ', $updateFields) . " WHERE idusuario = ?";
            $params[] = $idusuario;
            $types .= 'i';

            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Função auxiliar para mysqli_stmt_bind_param
                $bindParams = array_merge([$types], $params);
                call_user_func_array([$stmt, 'bind_param'], refValues($bindParams));

                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $response['success'] = true;
                        $response['message'] = 'Usuário atualizado com sucesso.';
                    } else {
                        // Pode acontecer se nenhum dado for realmente alterado, mas a query rodar
                        $response['success'] = true; // Ainda é um sucesso, não houve erro na operação
                        $response['message'] = 'Nenhuma alteração detectada.';
                    }
                } else {
                    $response['message'] = 'Erro ao executar a atualização: ' . $stmt->error;
                }
                $stmt->close();
            } else {
                $response['message'] = 'Erro na preparação da declaração SQL: ' . $conn->error;
            }
        } else {
            $response['message'] = 'Nenhum campo para atualizar fornecido.';
        }
    } else {
        $response['message'] = 'ID do usuário não fornecido.';
    }
} else {
    $response['message'] = 'Método de requisição inválido.';
}

echo json_encode($response);

// Função auxiliar para mysqli_stmt_bind_param (necessário para PHP < 5.6 com call_user_func_array)
function refValues($arr){
    if (strnatcmp(phpversion(),'5.3') >= 0) {
        $refs = array();
        foreach($arr as $key => $value)
            $refs[$key] = &$arr[$key];
        return $refs;
    }
    return $arr;
}
?>