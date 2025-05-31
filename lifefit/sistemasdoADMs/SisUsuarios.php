<?php
// Inclui o arquivo de conexão com o banco de dados
include_once '../conexao.php';

// Consulta SQL para selecionar todos os usuários, ordenados pelo ID em ordem decrescente.
// Importante: NÃO selecione a coluna 'senha' diretamente aqui para evitar exposição desnecessária.
$sql = "SELECT idusuario, nome, email FROM usuario ORDER BY idusuario DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - Usuários</title>
    <link rel="stylesheet" href="../style/SISTEMA.CSS">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Estilos para campos editáveis na tabela */
        .editable-field {
            border: 1px solid transparent;
            padding: 2px 5px;
            cursor: pointer;
            width: 90%; /* Ajusta a largura do campo de input/textarea */
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
        /* Estilos para o contêiner dos botões de ação */
        .action-buttons {
            display: flex;
            gap: 5px; /* Espaçamento entre os botões */
            justify-content: center; /* Centraliza os botões */
            flex-wrap: wrap; /* Permite que os botões quebrem a linha */
        }
        /* Oculta os botões de salvar/cancelar por padrão */
        .action-buttons .save-btn,
        .action-buttons .cancel-btn {
            display: none;
        }
        /* Estilo para os botões gerais */
        .btn {
            padding: 5px 10px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
            color: white;
            font-size: 14px;
            white-space: nowrap; /* Evita que o texto do botão quebre */
        }
        /* Cores específicas para os botões */
        .btn-primary { background-color: #007bff; } /* Azul para editar */
        .btn-success { background-color: #28a745; } /* Verde para salvar */
        .btn-danger { background-color: #dc3545; } /* Vermelho para cancelar e excluir */
        .btn-warning { background-color: #ffc107; color: #333; } /* Amarelo para Redefinir Senha */

        /* Estilos para o Modal (pop-up de redefinição de senha) */
        .modal {
            display: none; /* Oculto por padrão */
            position: fixed; /* Fixado na tela */
            z-index: 1; /* Acima de outros elementos */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Permite scroll se o conteúdo for grande */
            background-color: rgba(0,0,0,0.4); /* Fundo semi-transparente escuro */
            padding-top: 60px;
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 5% do topo e centralizado horizontalmente */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Largura padrão */
            max-width: 500px; /* Largura máxima */
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            color: #333; /* Cor do texto dentro do modal */
        }
        .modal-content h3 {
            margin-top: 0;
            color: #333;
        }
        .modal-content label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        /* Contêiner para o campo de senha e o ícone do "olhinho" */
        .password-input-container {
            position: relative;
            margin-bottom: 15px;
            display: flex; /* Usa flexbox para alinhar input e ícone */
            align-items: center; /* Centraliza verticalmente os itens */
        }
        /* Estilos para o campo de input de senha dentro do contêiner */
        .password-input-container input[type="password"],
        .password-input-container input[type="text"] { /* Aplica para ambos os tipos */
            flex-grow: 1; /* Faz o input ocupar o máximo de espaço disponível */
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding-right: 40px; /* Garante espaço suficiente para o ícone */
        }
        /* Estilos para o ícone do "olhinho" */
        .toggle-password {
            position: absolute; /* Posição absoluta em relação ao .password-input-container */
            right: 10px; /* 10px da borda direita do input */
            cursor: pointer;
            color: #888;
            padding: 5px; /* Aumenta a área clicável */
        }
        .toggle-password:hover {
            color: #333;
        }

        .modal-footer {
            text-align: right;
            margin-top: 20px;
        }
        .modal-footer .btn {
            margin-left: 10px;
        }
        /* Botão de fechar do modal */
        .close-button {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        .close-button:hover,
        .close-button:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="user-data-box">
            <h2>Dados dos Usuários</h2>
            <div class="table-responsive">
                <table class="table text-white table-bg">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Email</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Verifica se há resultados da consulta
                        if ($result->num_rows > 0) {
                            // Loop para exibir cada linha de usuário
                            while($user_data = mysqli_fetch_assoc($result)) {
                                // Adiciona o atributo data-id para referenciar o ID do usuário no JavaScript
                                echo "<tr data-id='" . htmlspecialchars($user_data['idusuario']) . "'>";
                                echo "<td>" . htmlspecialchars($user_data['idusuario']) . "</td>";
                                // Campos editáveis com a classe 'editable' e 'data-field'
                                echo "<td class='editable' data-field='nome'>" . htmlspecialchars($user_data['nome']) . "</td>";
                                echo "<td class='editable' data-field='email'>" . htmlspecialchars($user_data['email']) . "</td>";
                                echo "<td class='action-buttons'>";
                                // Botões de ação
                                echo "  <button class='btn btn-primary edit-btn'><i class='fa-solid fa-edit'></i> Editar</button>";
                                echo "  <button class='btn btn-warning reset-password-btn'><i class='fa-solid fa-key'></i> Redefinir Senha</button>";
                                echo "  <button class='btn btn-danger delete-btn'><i class='fa-solid fa-trash-alt'></i> Excluir</button>";
                                // Botões de salvar/cancelar (ocultos por padrão)
                                echo "  <button class='btn btn-success save-btn' style='display:none;'><i class='fa-solid fa-save'></i> Salvar</button>";
                                echo "  <button class='btn btn-danger cancel-btn' style='display:none;'><i class='fa-solid fa-times'></i> Cancelar</button>";
                                echo "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4'>Nenhum usuário encontrado.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="resetPasswordModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span> <h3>Redefinir Senha para <span id="userNameForPasswordReset"></span></h3>
            <form id="resetPasswordForm">
                <input type="hidden" id="resetPasswordUserId" name="idusuario"> <label for="newPassword">Nova Senha:</label>
                <div class="password-input-container">
                    <input type="password" id="newPassword" name="new_password" required minlength="6">
                    <i class="fa-solid fa-eye toggle-password" data-target="newPassword"></i> </div>

                <label for="confirmPassword">Confirmar Nova Senha:</label>
                <div class="password-input-container">
                    <input type="password" id="confirmPassword" name="confirm_password" required minlength="6">
                    <i class="fa-solid fa-eye toggle-password" data-target="confirmPassword"></i> </div>
                
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success">Salvar Nova Senha</button>
                    <button type="button" class="btn btn-danger" id="cancelResetPassword">Cancelar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Referências aos elementos do modal
            const resetPasswordModal = document.getElementById('resetPasswordModal');
            const closeButton = document.querySelector('.close-button');
            const cancelResetPasswordBtn = document.getElementById('cancelResetPassword');
            const resetPasswordForm = document.getElementById('resetPasswordForm');
            const resetPasswordUserIdField = document.getElementById('resetPasswordUserId');
            const userNameForPasswordReset = document.getElementById('userNameForPasswordReset');
            const newPasswordField = document.getElementById('newPassword');
            const confirmPasswordField = document.getElementById('confirmPassword');

            // Função para fechar o modal
            function closeModal() {
                resetPasswordModal.style.display = 'none';
                resetPasswordForm.reset(); // Limpa os campos do formulário
                // Garante que os campos de senha voltem a ser do tipo 'password' e os ícones para 'fa-eye'
                newPasswordField.type = 'password';
                confirmPasswordField.type = 'password';
                document.querySelectorAll('.toggle-password').forEach(icon => {
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                });
            }

            // Event listeners para fechar o modal
            closeButton.addEventListener('click', closeModal);
            cancelResetPasswordBtn.addEventListener('click', closeModal);
            window.addEventListener('click', function(event) {
                if (event.target == resetPasswordModal) {
                    closeModal();
                }
            });

            // Lógica para os botões de EDITAR (nome/email)
            document.querySelectorAll('.edit-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    // Oculta botões de ação e mostra salvar/cancelar
                    this.style.display = 'none';
                    row.querySelector('.reset-password-btn').style.display = 'none';
                    row.querySelector('.delete-btn').style.display = 'none';
                    row.querySelector('.save-btn').style.display = 'inline-block';
                    row.querySelector('.cancel-btn').style.display = 'inline-block';

                    // Torna campos editáveis
                    row.querySelectorAll('.editable').forEach(cell => {
                        const originalContent = cell.textContent;
                        const fieldName = cell.dataset.field;
                        cell.dataset.original = originalContent;

                        let inputField = document.createElement('input');
                        inputField.type = (fieldName === 'email') ? 'email' : 'text';
                        inputField.value = originalContent;
                        inputField.className = 'form-control editable-field editing';
                        cell.innerHTML = '';
                        cell.appendChild(inputField);
                    });
                });
            });

            // Lógica para os botões de SALVAR (nome/email)
            document.querySelectorAll('.save-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const usuarioId = row.dataset.id;
                    const updatedData = { id: usuarioId };

                    row.querySelectorAll('.editable').forEach(cell => {
                        const fieldName = cell.dataset.field;
                        const inputField = cell.querySelector('input');
                        if (inputField) {
                            updatedData[fieldName] = inputField.value;
                        }
                    });

                    fetch('update_usuario.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify(updatedData),
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Erro de rede ou servidor com status: ' + response.status);
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            row.querySelectorAll('.editable').forEach(cell => {
                                const inputField = cell.querySelector('input');
                                if (inputField) cell.textContent = inputField.value;
                                cell.classList.remove('editing');
                            });
                            // Restaura visibilidade dos botões
                            row.querySelector('.save-btn').style.display = 'none';
                            row.querySelector('.cancel-btn').style.display = 'none';
                            row.querySelector('.edit-btn').style.display = 'inline-block';
                            row.querySelector('.reset-password-btn').style.display = 'inline-block';
                            row.querySelector('.delete-btn').style.display = 'inline-block';
                            alert('Dados do usuário atualizados com sucesso!');
                        } else {
                            alert('Erro ao atualizar dados do usuário: ' + data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Erro:', error);
                        alert('Ocorreu um erro na requisição. Verifique o console para mais detalhes.');
                    });
                });
            });

            // Lógica para os botões de CANCELAR
            document.querySelectorAll('.cancel-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    row.querySelectorAll('.editable').forEach(cell => {
                        cell.textContent = cell.dataset.original;
                        cell.classList.remove('editing');
                    });
                    // Restaura visibilidade dos botões
                    row.querySelector('.save-btn').style.display = 'none';
                    row.querySelector('.cancel-btn').style.display = 'none';
                    row.querySelector('.edit-btn').style.display = 'inline-block';
                    row.querySelector('.reset-password-btn').style.display = 'inline-block';
                    row.querySelector('.delete-btn').style.display = 'inline-block';
                });
            });

            // Lógica para os botões de EXCLUIR
            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const usuarioId = row.dataset.id;
                    const nomeUsuario = row.querySelector('.editable[data-field="nome"]').textContent;

                    if (confirm(`Tem certeza que deseja excluir o usuário "${nomeUsuario}" (ID: ${usuarioId})? Esta ação é irreversível.`)) {
                        fetch('delete_usuario.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/json' },
                            body: JSON.stringify({ id: usuarioId }),
                        })
                        .then(response => {
                            if (!response.ok) throw new Error('Erro de rede ou servidor com status: ' + response.status);
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                alert('Usuário excluído com sucesso!');
                                row.remove(); // Remove a linha da tabela
                            } else {
                                alert('Erro ao excluir usuário: ' + data.message);
                            }
                        })
                        .catch(error => {
                            console.error('Erro:', error);
                            alert('Ocorreu um erro na requisição de exclusão. Verifique o console para mais detalhes.');
                        });
                    }
                });
            });

            // Lógica para o botão de REDEFINIR SENHA (abre o modal)
            document.querySelectorAll('.reset-password-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const row = this.closest('tr');
                    const usuarioId = row.dataset.id;
                    const nomeUsuario = row.querySelector('.editable[data-field="nome"]').textContent;

                    resetPasswordUserIdField.value = usuarioId;
                    userNameForPasswordReset.textContent = nomeUsuario;
                    resetPasswordModal.style.display = 'block'; // Exibe o modal
                });
            });

            // Lógica de submissão do formulário de redefinição de senha
            resetPasswordForm.addEventListener('submit', function(event) {
                event.preventDefault(); // Impede o envio padrão do formulário

                const newPassword = newPasswordField.value;
                const confirmPassword = confirmPasswordField.value;

                if (newPassword !== confirmPassword) {
                    alert('As senhas não coincidem!');
                    return;
                }
                if (newPassword.length < 6) { // Validação mínima de 6 caracteres
                    alert('A nova senha deve ter pelo menos 6 caracteres.');
                    return;
                }

                const usuarioId = resetPasswordUserIdField.value;

                fetch('reset_password_usuario.php', { // Requisição para o script de redefinição de senha
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ id: usuarioId, new_password: newPassword }),
                })
                .then(response => {
                    if (!response.ok) throw new Error('Erro de rede ou servidor com status: ' + response.status);
                    return response.json();
                })
                .then(data => {
                    if (data.success) {
                        alert('Senha redefinida com sucesso!');
                        closeModal(); // Fecha o modal após sucesso
                    } else {
                        alert('Erro ao redefinir senha: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Erro:', error);
                    alert('Ocorreu um erro na requisição de redefinição de senha. Verifique o console para mais detalhes.');
                });
            });

            // Lógica para o "olhinho" de ver/esconder senha
            document.querySelectorAll('.toggle-password').forEach(icon => {
                icon.addEventListener('click', function() {
                    const targetId = this.dataset.target; // Obtém o ID do input alvo
                    const targetInput = document.getElementById(targetId);

                    if (targetInput.type === 'password') {
                        targetInput.type = 'text';
                        this.classList.remove('fa-eye');
                        this.classList.add('fa-eye-slash'); // Muda para o ícone de olho cortado
                    } else {
                        targetInput.type = 'password';
                        this.classList.remove('fa-eye-slash');
                        this.classList.add('fa-eye'); // Muda para o ícone de olho aberto
                    }
                });
            });
        });
    </script>
</body>
</html>