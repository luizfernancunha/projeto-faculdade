// --- Seleção de Elementos e Configuração Inicial ---
const container = document.querySelector('.container');
const registerBtn = document.querySelector('.register-btn');
const loginBtn = document.querySelector('.login-btn');

// Elementos do formulário de REGISTRO
const registerForm = document.querySelector('.form-box.register form');
const mensagemRegistroDiv = document.getElementById('mensagemRegistro'); // Pega a div existente no HTML

// Elementos do formulário de LOGIN
const loginForm = document.querySelector('.form-box.login form');
const loginMessageDiv = document.getElementById('loginMessage');

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

// --- Funcionalidade de Mostrar/Esconder Senha ---

// Para o formulário de Login
const loginPasswordInput = document.getElementById('loginPassword');
const toggleLoginPassword = document.getElementById('toggleLoginPassword');

if (toggleLoginPassword && loginPasswordInput) {
    toggleLoginPassword.addEventListener('click', function() {
        // Alterna o atributo 'type' entre 'password' e 'text'
        const type = loginPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        loginPasswordInput.setAttribute('type', type);

        // Alterna os ícones de olho (aberto/fechado)
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash'); // 'fa-eye-slash' é o ícone de olho cortado
    });
}

// Para o formulário de Registro
const registerPasswordInput = document.getElementById('registerPassword');
const toggleRegisterPassword = document.getElementById('toggleRegisterPassword');

if (toggleRegisterPassword && registerPasswordInput) {
    toggleRegisterPassword.addEventListener('click', function() {
        // Alterna o atributo 'type' entre 'password' e 'text'
        const type = registerPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
        registerPasswordInput.setAttribute('type', type);

        // Alterna os ícones de olho (aberto/fechado)
        this.classList.toggle('fa-eye');
        this.classList.toggle('fa-eye-slash'); // 'fa-eye-slash' é o ícone de olho cortado
    });
}

