
    document.getElementById('cadastroPacienteForm').addEventListener('submit', function(event) {
        // Impede o comportamento padrão de envio do formulário (que causaria um recarregamento da página)
        event.preventDefault();

        const form = event.target;
        const formData = new FormData(form); // Pega todos os dados do formulário
        const responseMessageDiv = document.getElementById('responseMessage');

        // Limpa mensagens anteriores
        responseMessageDiv.textContent = '';
        responseMessageDiv.style.color = '';

        fetch(form.action, {
            method: form.method,
            body: formData
        })
        .then(response => response.text()) // Pega a resposta como texto simples
        .then(data => {
            // PHP ecoa "success" ou "error" seguido por uma mensagem
            if (data.startsWith('success:')) {
                responseMessageDiv.textContent = data.substring(8); // Remove o prefixo "success:"
                // === AQUI ESTÁ A MUDANÇA PARA A COR AZUL VIOLETA ===
                responseMessageDiv.style.color = 'blueviolet'; // Cor azul violeta
                // ===================================================
                form.reset(); // Opcionalmente, limpa o formulário em caso de sucesso
            } else if (data.startsWith('error:')) {
                responseMessageDiv.textContent = data.substring(6); // Remove o prefixo "error:"
                responseMessageDiv.style.color = 'red'; // Erros continuam vermelhos
            } else {
                responseMessageDiv.textContent = 'Ocorreu um erro inesperado. Por favor, tente novamente.';
                responseMessageDiv.style.color = 'red';
                console.error('Resposta PHP inesperada:', data);
            }
        })
        .catch(error => {
            responseMessageDiv.textContent = 'Erro ao conectar com o servidor. Por favor, tente novamente.';
            responseMessageDiv.style.color = 'red';
            console.error('Erro na requisição Fetch:', error);
        });
    });
