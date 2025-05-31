<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../conexao.php';

header('Content-Type: application/json');

$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $idavaliacao = (int)$data['id'];

        $updateFields = [];
        $params = [];
        $types = '';

        if (isset($data['nome'])) {
            $updateFields[] = "nome = ?";
            $params[] = $data['nome'];
            $types .= 's';
        }
        if (isset($data['dataAvaliacao'])) {
            $updateFields[] = "dataAvaliacao = ?";
            $params[] = $data['dataAvaliacao'];
            $types .= 's';
        }
        if (isset($data['PlanoExercicios'])) {
            $updateFields[] = "PlanoExercicios = ?";
            $params[] = $data['PlanoExercicios'];
            $types .= 's';
        }
        if (isset($data['PlanoAlimentar'])) {
            $updateFields[] = "PlanoAlimentar = ?";
            $params[] = $data['PlanoAlimentar'];
            $types .= 's';
        }

        if (!empty($updateFields)) {
            $sql = "UPDATE avaliacao SET " . implode(', ', $updateFields) . " WHERE idavaliacao = ?";
            $params[] = $idavaliacao;
            $types .= 'i';

            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $bindParams = array_merge([$types], $params);
                call_user_func_array([$stmt, 'bind_param'], refValues($bindParams));

                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Avaliação atualizada com sucesso.';
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
        $response['message'] = 'ID da avaliação não fornecido.';
    }
} else {
    $response['message'] = 'Método de requisição inválido.';
}

echo json_encode($response);

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