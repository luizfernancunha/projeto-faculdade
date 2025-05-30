const form = document.getElementById('form');
const infosDiv = document.getElementById('infos');

form.addEventListener('submit', function(event) {
    event.preventDefault();

    const gender = document.getElementById('gender').value;
    // ALTERAÇÃO AQUI: Apenas pega o valor numérico da idade
    const age = parseFloat(document.getElementById('age').value); 
    const weight = parseFloat(document.getElementById('weight').value);
    const height = parseFloat(document.getElementById('height').value);
    const activity = document.getElementById('activity').value;

    // --- Validação de Entrada ---
    // Agora verifica se a idade é um número válido e maior que zero.
    if (isNaN(weight) || weight <= 0 || isNaN(height) || height <= 0 || 
        isNaN(age) || age <= 0 || !gender || !activity) {
        alert('Por favor, preencha todos os campos com valores numéricos válidos e maiores que zero (exceto Sexo e Atividade).');
        infosDiv.classList.add('hidden'); // Esconde a seção de resultados
        return;
    }

    // --- Cálculo da TMB (Taxa Metabólica Basal) - Fórmula de Mifflin-St Jeor ---
    let tmb;
    const heightCm = height * 100; 

    if (gender === 'male') {
        tmb = (10 * weight) + (6.25 * heightCm) - (5 * age) + 5;
    } else { // female
        tmb = (10 * weight) + (6.25 * heightCm) - (5 * age) - 161;
    }

    // --- Cálculo do Fator de Atividade Física (FAF) ---
    let activityFactor;
    switch (activity) {
        case 'sedentary':
            activityFactor = 1.2;
            break;
        case 'light':
            activityFactor = 1.375;
            break;
        case 'moderate':
            activityFactor = 1.55;
            break;
        case 'heavy':
            activityFactor = 1.725;
            break;
        case 'athlete':
            activityFactor = 1.9;
            break;
        default:
            activityFactor = 1.2;
    }

    // --- Cálculo do Gasto Energético Total Diário (GET) ---
    const get = (tmb * activityFactor).toFixed(0);

    // --- Cálculo do IMC ---
    const bmi = (weight / (height * height)).toFixed(2);

    const valueElement = document.getElementById('value');
    let description = '';
    let calorieRecommendation = '';

    valueElement.classList.remove('normal', 'attention');
    valueElement.classList.add('attention');
    
    infosDiv.classList.remove('hidden');

    // Determina a descrição do IMC e a recomendação de calorias
    if (bmi < 18.5) {
        description = 'Cuidado! Você está abaixo do peso!';
        calorieRecommendation = `Para ganhar peso de forma saudável, você pode tentar consumir aproximadamente ${parseInt(get) + 300} calorias por dia (um superávit de cerca de 300 calorias).`;
    } else if (bmi >= 18.5 && bmi <= 24.9) {
        description = "Você está no peso ideal!";
        valueElement.classList.remove('attention');
        valueElement.classList.add('normal');
        calorieRecommendation = `Para manter seu peso atual, você deve consumir aproximadamente ${get} calorias por dia.`;
    } else if (bmi >= 25 && bmi <= 29.9) {
        description = "Cuidado! Você está com sobrepeso!";
        calorieRecommendation = `Para perder peso de forma saudável, você pode tentar consumir aproximadamente ${parseInt(get) - 500} calorias por dia (um déficit de cerca de 500 calorias).`;
    } else if (bmi >= 30 && bmi <= 34.9) {
        description = "Cuidado! Você está com obesidade Grau I!";
        calorieRecommendation = `Para perder peso de forma saudável, você pode tentar consumir aproximadamente ${parseInt(get) - 700} calorias por dia (um déficit de cerca de 700 calorias).`;
    } else if (bmi >= 35 && bmi <= 39.9) {
        description = "Cuidado! Você está com obesidade Grau II (severa)!";
        calorieRecommendation = `Para perder peso de forma saudável, você pode tentar consumir aproximadamente ${parseInt(get) - 800} calorias por dia (um déficit de cerca de 800 calorias).`;
    } else {
        description = "Cuidado! Você está com obesidade Grau III (mórbida)!";
        calorieRecommendation = `Para perder peso de forma saudável, você pode tentar consumir aproximadamente ${parseInt(get) - 1000} calorias por dia (um déficit de cerca de 1000 calorias).`;
    }

    document.getElementById('value').textContent = bmi.replace('.', ',');
    document.getElementById('description').innerHTML = `${description}<br><br>**Recomendação de Calorias:** ${calorieRecommendation}`;
});

form.addEventListener('keypress', function(event) {
    if (event.key === 'Enter') {
        document.getElementById('calculate').click();
    }
});