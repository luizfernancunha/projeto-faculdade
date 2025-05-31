<?php
// Ativar exibição de erros para depuração. REMOVA ISSO EM AMBIENTE DE PRODUÇÃO!
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../conexao.php'; // Caminho para o arquivo de conexão

header('Content-Type: application/json'); // Define o cabeçalho da resposta como JSON

$response = ['success' => false, 'message' => '']; // Estrutura da resposta padrão

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    if (isset($data['id'])) {
        $idpaciente = (int)$data['id'];

        $updateFields = [];
        $params = [];
        $types = '';

        if (isset($data['nome'])) {
            $updateFields[] = "nome = ?";
            $params[] = $data['nome'];
            $types .= 's';
        }
        if (isset($data['datanacimento'])) {
            $updateFields[] = "datanacimento = ?";
            $params[] = $data['datanacimento'];
            $types .= 's';
        }
        if (isset($data['genero'])) {
            $updateFields[] = "genero = ?";
            $params[] = $data['genero'];
            $types .= 's';
        }
        if (isset($data['altura'])) {
            $updateFields[] = "altura = ?";
            $params[] = (float)$data['altura'];
            $types .= 'd'; // 'd' para double/float
        }
        if (isset($data['peso'])) {
            $updateFields[] = "peso = ?";
            $params[] = (float)$data['peso'];
            $types .= 'd'; // 'd' para double/float
        }
        if (isset($data['nivel_de_atividade'])) {
            $updateFields[] = "nivel_de_atividade = ?";
            $params[] = $data['nivel_de_atividade'];
            $types .= 's';
        }
        if (isset($data['objetivo'])) {
            $updateFields[] = "objetivo = ?";
            $params[] = $data['objetivo'];
            $types .= 's';
        }

        if (!empty($updateFields)) {
            $sql = "UPDATE paciente SET " . implode(', ', $updateFields) . " WHERE idpaciente = ?";
            $params[] = $idpaciente;
            $types .= 'i'; // 'i' para integer

            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $bindParams = array_merge([$types], $params);
                call_user_func_array([$stmt, 'bind_param'], refValues($bindParams));

                if ($stmt->execute()) {
                    $response['success'] = true;
                    $response['message'] = 'Dados do paciente atualizados com sucesso.';
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
        $response['message'] = 'ID do paciente não fornecido.';
    }
} else {
    $response['message'] = 'Método de requisição inválido.';
}

echo json_encode($response);

// Função auxiliar para passar parâmetros por referência para bind_param
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