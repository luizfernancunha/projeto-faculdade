<?php
include_once '../conexao.php'; // Inclui a conexão com o banco de dados

$sql = "SELECT * FROM paciente ORDER BY idpaciente DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - GN</title>
    <link rel="stylesheet" href="../style/SISTEMA.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Estilos para campos editáveis e botões */
        .editable-field {
            border: 1px solid transparent;
            padding: 2px 5px;
            cursor: pointer;
            width: 90%;
            box-sizing: border-box;
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
            justify-content: center;
            align-items: center; /* Alinha verticalmente os botões */
        }
        .action-buttons .save-btn,
        .action-buttons .cancel-btn {
            display: none;
        }
        /* Estilo básico para os botões */
        .btn {
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            color: white;
            white-space: nowrap; /* Evita que o texto ou ícone quebre a linha */
        }
        .btn-primary { background-color: #007bff; }
        .btn-success { background-color: #28a745; }
        .btn-danger { background-color: #dc3545; }
    </style>
</head>
<body>

    <div class="container">
        <div class="user-data-box">
            <h2>Dados do Paciente</h2>
            <div class="table-responsive">
                <table class="table text-white table-bg">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data de Nascimento</th>
                            <th scope="col">Gênero</th>
                            <th scope="col">Altura</th>
                            <th scope="col">Peso</th>
                            <th scope="col">Nível de Atividade</th>
                            <th scope="col">Objetivo</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while($user_data = mysqli_fetch_assoc($result)) {
                            echo "<tr data-id='" . $user_data['idpaciente'] . "'>";
                            echo "<td>" . htmlspecialchars($user_data['idpaciente']) . "</td>";
                            echo "<td class='editable' data-field='nome'>" . htmlspecialchars($user_data['nome']) . "</td>";
                            echo "<td class='editable' data-field='datanacimento'>" . htmlspecialchars($user_data['datanacimento']) . "</td>";
                            echo "<td class='editable' data-field='genero'>" . htmlspecialchars($user_data['genero']) . "</td>";
                            echo "<td class='editable' data-field='altura'>" . htmlspecialchars($user_data['altura']) . "</td>";
                            echo "<td class='editable' data-field='peso'>" . htmlspecialchars($user_data['peso']) . "</td>";
                            echo "<td class='editable' data-field='nivel_de_atividade'>" . htmlspecialchars($user_data['nivel_de_atividade']) . "</td>";
                            echo "<td class='editable' data-field='objetivo'>" . htmlspecialchars($user_data['objetivo']) . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "  <button class='btn btn-primary edit-btn'><i class='fa-solid fa-edit'></i></button>";
                            echo "  <button class='btn btn-success save-btn' style='display:none;'><i class='fa-solid fa-save'></i></button>";
                            echo "  <button class='btn btn-danger cancel-btn' style='display:none;'><i class='fa-solid fa-times'></i></button>";
                            echo "  <button class='btn btn-danger delete-btn' data-id='" . $user_data['idpaciente'] . "'><i class='fa-solid fa-trash-alt'></i></button>";
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
            // ----- FUNÇÕES DE AJUDA -----
            function setupEditMode(row) {
                // Esconde o botão de editar, mostra salvar e cancelar
                row.querySelector('.edit-btn').style.display = 'none';
                row.querySelector('.save-btn').style.display = 'inline-block';
                row.querySelector('.cancel-btn').style.display = 'inline-block';
                row.querySelector('.delete-btn').style.display = 'none'; // Esconde deletar durante a edição

                // Torna os campos editáveis
                row.querySelectorAll('.editable').forEach(cell => {
                    const originalContent = cell.textContent;
                    const fieldName = cell.dataset.field;
                    cell.dataset.original = originalContent; // Armazena original para cancelar

                    let inputField;
                    if (fieldName === 'datanacimento') {
                        inputField = document.createElement('input');
                        inputField.type = 'date';
                        inputField.value = originalContent;
                    } else if (fieldName === 'genero') {
                        inputField = document.createElement('select');
                        const genders = ['Masculino', 'Feminino', 'Outro'];
                        genders.forEach(gender => {
                            const option = document.createElement('option');
                            option.value = gender;
                            option.textContent = gender;
                            if (gender === originalContent) {
                                option.selected = true;
                            }
                            inputField.appendChild(option);
                        });
                    } else if (fieldName === 'nivel_de_atividade') {
                         inputField = document.createElement('select');
                         const levels = ['Sedentário', 'Pouco Ativo', 'Ativo', 'Muito Ativo'];
                         levels.forEach(level => {
                             const option = document.createElement('option');
                             option.value = level;
                             option.textContent = level;
                             if (level === originalContent) {
                                 option.selected = true;
                             }
                             inputField.appendChild(option);
                         });
                    } else if (fieldName === 'objetivo') {
                         inputField = document.createElement('select');
                         const objectives = ['Perder Peso', 'Ganhar Massa Muscular', 'Manter Peso', 'Outro'];
                         objectives.forEach(objective => {
                             const option = document.createElement('option');
                             option.value = objective;
                             option.textContent = objective;
                             if (objective === originalContent) {
                                 option.selected = true;
                             }
                             inputField.appendChild(option);
                         });
                    } else {
                        inputField = document.createElement('input');
                        inputField.type = 'text';
                        inputField.value = originalContent;
                    }

                    inputField.className = 'form-control editable-field editing';
                    cell.innerHTML = '';
                    cell.appendChild(inputField);
                });
            }

            function exitEditMode(row, revert = false) {
                row.querySelectorAll('.editable').forEach(cell => {
                    const inputField = cell.querySelector('input, select');
                    if (inputField) {
                        cell.textContent = revert ? cell.dataset.original : inputField.value;
                        cell.classList.remove('editing');
                    }
                });
                // Reverter botões
                row.querySelector('.save-btn').style.display = 'none';
                row.querySelector('.cancel-btn').style.display = 'none';
                row.querySelector('.edit-btn').style.display = 'inline-block';
                row.querySelector('.delete-btn').style.display = 'inline-block'; // Mostra o delete novamente
            }

            // ----- EVENT LISTENERS -----
            // Event listener para os botões de EDITAR
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    setupEditMode(this.closest('tr'));
                });
            });

            // Event listener para os botões de SALVAR
            document.querySelectorAll('.save-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const patientId = row.dataset.id;
                    const updatedData = { id: patientId };

                    row.querySelectorAll('.editable').forEach(cell => {
                        const fieldName = cell.dataset.field;
                        const inputField = cell.querySelector('input, select');
                        if (inputField) {
                            updatedData[fieldName] = inputField.value;
                        }
                    });

                    fetch('update_patient.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(updatedData),
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.text().then(text => { throw new Error('HTTP error! Status: ' + response.status + ' Response: ' + text); });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            exitEditMode(row, false); // Sai do modo de edição e atualiza valores
                            alert('Dados atualizados com sucesso!');
                        } else {
                            alert('Erro ao atualizar dados: ' + data.message);
                            exitEditMode(row, true); // Reverte e sai do modo de edição
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocorreu um erro na requisição. Verifique o console para mais detalhes.');
                        exitEditMode(row, true); // Reverte e sai do modo de edição
                    });
                });
            });

            // Event listener para os botões de CANCELAR
            document.querySelectorAll('.cancel-btn').forEach(button => {
                button.addEventListener('click', function() {
                    exitEditMode(this.closest('tr'), true); // Sai do modo de edição e reverte valores
                });
            });

            // Event listener para os botões de DELETAR
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const patientId = this.dataset.id;
                    const row = this.closest('tr');

                    if (confirm('Tem certeza que deseja EXCLUIR este registro do paciente? Esta ação é irreversível!')) {
                        fetch('delete_patient.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: patientId }),
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.text().then(text => { throw new Error('HTTP error! Status: ' + response.status + ' Response: ' + text); });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                alert('Registro do paciente excluído com sucesso!');
                                row.remove(); // Remove a linha da tabela da UI
                            } else {
                                alert('Erro ao excluir registro: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Ocorreu um erro na requisição de exclusão. Verifique o console.');
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>