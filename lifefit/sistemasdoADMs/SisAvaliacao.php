<?php
include_once '../conexao.php'; // Verifique se o caminho para 'conexao.php' está correto

$sql = "SELECT * FROM avaliacao ORDER BY idavaliacao DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br"> <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - GN</title>
    <link rel="stylesheet" href="../style/SISTEMA.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Estilos básicos para campos editáveis (copiados do SisPaciente.php) */
        .editable-field {
            border: 1px solid transparent;
            padding: 2px 5px;
            cursor: pointer;
            width: 90%; /* Ajuste a largura conforme necessário */
            box-sizing: border-box; /* Inclui padding e borda na largura total */
        }
        .editable-field:hover {
            background-color: #f0f0f0;
        }
        .editing {
            border: 1px solid #007bff;
            background-color: #fff;
            color: #333;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center; /* Centraliza os botões */
        }
        .action-buttons .save-btn,
        .action-buttons .cancel-btn {
            display: none; /* Esconde por padrão */
        }
        /* Estilo para os botões (se não tiver Bootstrap ou um estilo similar) */
        .btn {
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            color: white;
        }
        .btn-primary { background-color: #007bff; } /* Azul para editar */
        .btn-success { background-color: #28a745; } /* Verde para salvar */
        .btn-danger { background-color: #dc3545; } /* Vermelho para cancelar e excluir */
    </style>
</head>
<body>

    <div class="container">
        <div class="user-data-box">
            <h2>Dados da Avaliação</h2>
            <div class="table-responsive">
                <table class="table text-white table-bg">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data da Avaliação</th>
                            <th scope="col">Plano de Exercícios</th>
                            <th scope="col">Plano Alimentar</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($user_data = mysqli_fetch_assoc($result)) {
                            echo "<tr data-id='" . $user_data['idavaliacao'] . "'>";
                            echo "<td>" . $user_data['idavaliacao'] . "</td>";
                            // Usar htmlspecialchars para evitar XSS ao exibir dados
                            echo "<td class='editable' data-field='nome'>" . htmlspecialchars($user_data['nome']) . "</td>";
                            echo "<td class='editable' data-field='dataAvaliacao'>" . htmlspecialchars($user_data['dataAvaliacao']) . "</td>";
                            echo "<td class='editable' data-field='PlanoExercicios'>" . htmlspecialchars($user_data['PlanoExercicios']) . "</td>";
                            echo "<td class='editable' data-field='PlanoAlimentar'>" . htmlspecialchars($user_data['PlanoAlimentar']) . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "    <button class='btn btn-primary edit-btn'><i class='fa-solid fa-edit'></i></button>";
                            echo "    <button class='btn btn-danger delete-btn'><i class='fa-solid fa-trash-alt'></i></button>"; // Botão de Excluir
                            echo "    <button class='btn btn-success save-btn' style='display:none;'><i class='fa-solid fa-save'></i></button>";
                            echo "    <button class='btn btn-danger cancel-btn' style='display:none;'><i class='fa-solid fa-times'></i></button>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Event listener para os botões de EDITAR
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    // Esconde o botão de editar e excluir, mostra salvar e cancelar
                    this.style.display = 'none';
                    row.querySelector('.delete-btn').style.display = 'none'; // Esconde o botão de excluir
                    row.querySelector('.save-btn').style.display = 'inline-block';
                    row.querySelector('.cancel-btn').style.display = 'inline-block';

                    // Torna os campos editáveis
                    row.querySelectorAll('.editable').forEach(cell => {
                        const originalContent = cell.textContent;
                        const fieldName = cell.dataset.field;

                        // Armazena o conteúdo original para a operação de cancelar
                        cell.dataset.original = originalContent;

                        let inputField;
                        // Para 'dataAvaliacao', usar input type="date"
                        if (fieldName === 'dataAvaliacao') {
                            inputField = document.createElement('input');
                            inputField.type = 'date';
                            inputField.value = originalContent;
                        }
                        // Para 'PlanoExercicios' e 'PlanoAlimentar', usar textarea
                        else if (fieldName === 'PlanoExercicios' || fieldName === 'PlanoAlimentar') {
                            inputField = document.createElement('textarea');
                            inputField.rows = "4"; // Ajuste o número de linhas conforme necessário
                            inputField.value = originalContent;
                        }
                        // Para 'nome', usar input type="text"
                        else {
                            inputField = document.createElement('input');
                            inputField.type = 'text';
                            inputField.value = originalContent;
                        }

                        inputField.className = 'form-control editable-field editing';
                        cell.innerHTML = ''; // Limpa o conteúdo da célula
                        cell.appendChild(inputField); // Adiciona o campo de input/textarea
                    });
                });
            });

            // Event listener para os botões de SALVAR
            document.querySelectorAll('.save-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const avaliacaoId = row.dataset.id;
                    const updatedData = { id: avaliacaoId }; // Objeto para enviar os dados

                    row.querySelectorAll('.editable').forEach(cell => {
                        const fieldName = cell.dataset.field;
                        const inputField = cell.querySelector('input, select, textarea'); // Pode ser input, select ou textarea
                        if (inputField) {
                            updatedData[fieldName] = inputField.value;
                        }
                    });

                    // Envia os dados para o PHP usando AJAX
                    fetch('update_avaliacao.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(updatedData),
                    })
                    .then(response => {
                        if (!response.ok) { // Verifica se a resposta HTTP não foi OK (status 200)
                            throw new Error('Erro de rede ou servidor com status: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Atualiza a UI com os novos dados e volta para o modo de exibição
                            row.querySelectorAll('.editable').forEach(cell => {
                                const inputField = cell.querySelector('input, select, textarea');
                                if (inputField) {
                                    cell.textContent = inputField.value; // Atualiza a exibição com o novo valor
                                    cell.classList.remove('editing');
                                }
                            });
                            // Esconde salvar/cancelar, mostra editar e excluir
                            row.querySelector('.save-btn').style.display = 'none';
                            row.querySelector('.cancel-btn').style.display = 'none';
                            row.querySelector('.edit-btn').style.display = 'inline-block';
                            row.querySelector('.delete-btn').style.display = 'inline-block'; // Mostra o botão de excluir novamente
                            alert('Dados da avaliação atualizados com sucesso!');
                        } else {
                            alert('Erro ao atualizar dados: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocorreu um erro na requisição. Verifique o console para mais detalhes.');
                    });
                });
            });

            // Event listener para os botões de CANCELAR
            document.querySelectorAll('.cancel-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');

                    // Reverte os campos para o conteúdo original
                    row.querySelectorAll('.editable').forEach(cell => {
                        cell.textContent = cell.dataset.original; // Reverte para o conteúdo original armazenado
                        cell.classList.remove('editing');
                    });

                    // Esconde salvar/cancelar, mostra editar e excluir
                    row.querySelector('.save-btn').style.display = 'none';
                    row.querySelector('.cancel-btn').style.display = 'none';
                    row.querySelector('.edit-btn').style.display = 'inline-block';
                    row.querySelector('.delete-btn').style.display = 'inline-block'; // Mostra o botão de excluir novamente
                });
            });

            // NOVO: Event listener para os botões de EXCLUIR
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const avaliacaoId = row.dataset.id;
                    const nomeAvaliacao = row.querySelector('.editable[data-field="nome"]').textContent; // Pega o nome para a confirmação

                    if (confirm(`Tem certeza que deseja excluir a avaliação de "${nomeAvaliacao}" (ID: ${avaliacaoId})? Esta ação é irreversível.`)) {
                        fetch('delete_avaliacao.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({ id: avaliacaoId }),
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Erro de rede ou servidor com status: ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                alert('Avaliação excluída com sucesso!');
                                row.remove(); // Remove a linha da tabela
                            } else {
                                alert('Erro ao excluir avaliação: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Ocorreu um erro na requisição de exclusão. Verifique o console para mais detalhes.');
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>