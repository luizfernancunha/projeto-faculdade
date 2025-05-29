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



