const form = document.getElementById('form');

form.addEventListener('submit', function(event) {
    // Previne o comportamento padrão do evento submit do JS, ou seja,
    // impede o recarregamento da página
    event.preventDefault();

    const gender = document.getElementById('gender').value;
    const ageInput = document.getElementById('age').value; // Formato YYYY-MM-DD
    
    // Convertendo peso e altura para números
    const weight = parseFloat(document.getElementById('weight').value);
    const height = parseFloat(document.getElementById('height').value);

    // --- INÍCIO DA REVISÃO DE VALIDAÇÃO ---
    // Verifica se peso e altura são números válidos e se altura não é zero
    if (isNaN(weight) || weight <= 0 || isNaN(height) || height <= 0) {
        alert('Por favor, insira valores numéricos válidos e maiores que zero para peso e altura.');
        document.getElementById('infos').classList.add('hidden'); // Esconde a seção de resultados se a entrada for inválida
        return; // Interrompe a execução da função se a validação falhar
    }
    // --- FIM DA REVISÃO DE VALIDAÇÃO ---

    // Calcula a idade a partir da data de nascimento
    let age;
    if (ageInput) {
        const birthDate = new Date(ageInput);
        const today = new Date();
        age = today.getFullYear() - birthDate.getFullYear();
        const monthDiff = today.getMonth() - birthDate.getMonth();
        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
            age--;
        }
    } else {
        age = null; // Lida com o caso em que a idade não é fornecida
    }

    // Calcula o IMC
    const bmi = (weight / (height * height)).toFixed(2);

    const valueElement = document.getElementById('value');
    let description = '';

    // Remove classes anteriores e adiciona 'attention' por padrão
    valueElement.classList.remove('normal', 'attention');
    valueElement.classList.add('attention');
    
    document.getElementById('infos').classList.remove('hidden');

    // Determina a descrição com base no IMC
    if (bmi < 18.5){
        description = 'Cuidado! Você está abaixo do peso!';
    } else if (bmi >= 18.5 && bmi <= 24.9) { // Faixa de peso normal padrão
        description = "Você está no peso ideal!";
        valueElement.classList.remove('attention');
        valueElement.classList.add('normal');
    } else if (bmi >= 25 && bmi <= 29.9) { // Faixa de sobrepeso padrão
        description = "Cuidado! Você está com sobrepeso!";
    } else if (bmi >= 30 && bmi <= 34.9) { // Obesidade Grau I padrão
        description = "Cuidado! Você está com obesidade Grau I!";
    } else if (bmi >= 35 && bmi <= 39.9) { // Obesidade Grau II padrão
        description = "Cuidado! Você está com obesidade Grau II (severa)!";
    } else { // Obesidade Grau III padrão
        description = "Cuidado! Você está com obesidade Grau III (mórbida)!";
    }

    valueElement.textContent = bmi.replace('.', ','); // Exibe o IMC com vírgula para o padrão brasileiro
    document.getElementById('description').textContent = description;
});

// Listener de evento para a tecla "Enter" disparar o cálculo
form.addEventListener('keypress', function(event) {
    // Verifica se a tecla pressionada é "Enter" (código da tecla 13 ou event.key === 'Enter')
    if (event.key === 'Enter') {
        document.getElementById('calculate').click(); // Simula um clique no botão de calcular
    }
});