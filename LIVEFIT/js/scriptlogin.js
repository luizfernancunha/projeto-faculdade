// --- Seleção de Elementos e Configuração Inicial ---
const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

// Elementos do formulário de REGISTRO
const registerForm = document.querySelector('.form-box.register form');
const mensagemRegistroDiv = document.getElementById('mensagemRegistro'); // Pega a div existente no HTML

// Elementos do formulário de LOGIN
const loginForm = document.querySelector('.form-box.login form');
// Pega a div de mensagem de login que agora está no HTML (recomendado)
const loginMessageDiv = document.getElementById('loginMessage');
// Se você preferir que o JS crie, remova a div do HTML e descomente o bloco abaixo:
/*
const loginMessageDiv = document.createElement('div');
loginMessageDiv.style.textAlign = 'center';
loginMessageDiv.style.fontWeight = 'bold';
loginMessageDiv.style.marginBottom = '10px';
loginMessageDiv.id = 'loginMessage';
if (!loginForm.querySelector('#loginMessage')) {
    loginForm.prepend(loginMessageDiv);
}
*/


// --- Lógica dos Botões de Alternância (Registro/Login) ---
registerBtn.addEventListener('click', () => {
    container.classList.add('active');
    // Limpa as mensagens de ambos os formulários ao alternar
    if (mensagemRegistroDiv) { // Verifica se a div existe antes de manipular
        mensagemRegistroDiv.textContent = '';
        mensagemRegistroDiv.style.display = 'none';
    }
    if (loginMessageDiv) { // Verifica se a div existe antes de manipular
        loginMessageDiv.textContent = '';
        loginMessageDiv.style.display = 'none';
    }
});

loginBtn.addEventListener('click', () => {
    container.classList.remove('active');
    // Limpa as mensagens de ambos os formulários ao alternar
    if (mensagemRegistroDiv) {
        mensagemRegistroDiv.textContent = '';
        mensagemRegistroDiv.style.display = 'none';
    }
    if (loginMessageDiv) {
        loginMessageDiv.textContent = '';
        loginMessageDiv.style.display = 'none';
    }
});


// --- Lógica de Submissão do Formulário de REGISTRO ---
if (registerForm) { // Garante que o formulário foi encontrado antes de adicionar o listener
    registerForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Impede o envio padrão do formulário

        const formData = new FormData(registerForm);

        // Limpa a mensagem anterior antes de uma nova tentativa de registro
        if (mensagemRegistroDiv) {
            mensagemRegistroDiv.textContent = '';
            mensagemRegistroDiv.style.display = 'none';
        }

        try {
            const response = await fetch(registerForm.action, {
                method: 'POST',
                body: formData
            });

            const result = await response.json(); // Analisa a resposta JSON

            if (mensagemRegistroDiv) {
                // Define a cor 'blueviolet' para ambas as mensagens (sucesso ou falha de registro)
                mensagemRegistroDiv.style.color = '#8A2BE2'; // blueviolet hexadecimal

                if (result.success) {
                    mensagemRegistroDiv.textContent = result.message; // Ex: "Registro realizado com sucesso!"
                } else {
                    // Se houver um erro (ex: email já registrado), exibe a mensagem de erro do PHP
                    mensagemRegistroDiv.textContent = result.message; // Ex: "Este email já está registrado."
                }
                mensagemRegistroDiv.style.display = 'block'; // Garante que a div esteja visível
            }

        } catch (error) {
            console.error('Erro na requisição de registro:', error);
            if (mensagemRegistroDiv) {
                mensagemRegistroDiv.style.color = 'red'; // Em caso de erro de rede ou JS, mantém vermelho
                mensagemRegistroDiv.textContent = 'Ocorreu um erro ao tentar registrar. Tente novamente.';
                mensagemRegistroDiv.style.display = 'block';
            }
        }
    });
}


// --- Lógica de Submissão do Formulário de LOGIN ---
if (loginForm) { // Garante que o formulário foi encontrado antes de adicionar o listener
    loginForm.addEventListener('submit', async (event) => {
        event.preventDefault(); // Impede o envio padrão do formulário

        const formData = new FormData(loginForm);

        // Limpa a mensagem anterior antes de uma nova tentativa de login
        if (loginMessageDiv) {
            loginMessageDiv.textContent = '';
            loginMessageDiv.style.display = 'none';
        }

        try {
            const response = await fetch(loginForm.action, {
                method: 'POST',
                body: formData
            });

            const result = await response.json(); // Analisa a resposta JSON

            if (loginMessageDiv) {
                if (result.success) {
                    loginMessageDiv.style.color = '#8A2BE2'; // Cor para sucesso do login
                    loginMessageDiv.textContent = result.message;
                    // Redireciona o usuário para a página indicada no PHP
                    if (result.redirect) {
                        setTimeout(() => { // Pequeno atraso para o usuário ver a mensagem
                            window.location.href = result.redirect;
                        }, 1000);
                    }
                } else {
                    loginMessageDiv.style.color = 'red'; // Cor para falha do login
                    loginMessageDiv.textContent = result.message;
                }
                loginMessageDiv.style.display = 'block';
            }

        } catch (error) {
            console.error('Erro na requisição de login:', error);
            if (loginMessageDiv) {
                loginMessageDiv.style.color = 'red';
                loginMessageDiv.textContent = 'Ocorreu um erro ao tentar fazer login. Tente novamente.';
                loginMessageDiv.style.display = 'block';
            }
        }
    });
}