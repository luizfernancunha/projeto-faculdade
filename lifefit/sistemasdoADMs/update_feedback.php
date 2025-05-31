<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../conexao.php'; // Verifique o caminho para 'conexao.php'

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $idfeedback = (int)$data['id'];

        $updateFields = [];
        $params = [];
        $types = '';

        // Adiciona campos para atualização se existirem nos dados recebidos
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
        if (isset($data['mensagem'])) {
            $updateFields[] = "mensagem = ?";
            $params[] = $data['mensagem'];
            $types .= 's';
        }

        if (!empty($updateFields)) {
            $sql = "UPDATE feedback SET " . implode(', ', $updateFields) . " WHERE idfeedback = ?";
            $params[] = $idfeedback; // Adiciona o ID ao final dos parâmetros
            $types .= 'i'; // Adiciona o tipo 'i' para o ID

            $stmt = $conn->prepare($sql);

            if ($stmt) {
                // Monta a lista de referências para bind_param
                $bindParams = array_merge([$types], $params);
                call_user_func_array([$stmt, 'bind_param'], refValues($bindParams));

                if ($stmt->execute()) {
                    if ($stmt->affected_rows > 0) {
                        $response['success'] = true;
                        $response['message'] = 'Feedback atualizado com sucesso.';
                    } else {
                        $response['message'] = 'Nenhuma alteração feita ou feedback não encontrado.';
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
        $response['message'] = 'ID do feedback não fornecido.';
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