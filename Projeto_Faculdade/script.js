// --- Documentação do Código JavaScript ---
// Este script captura os valores do formulário HTML, calcula o gasto calórico diário
// e exibe o resultado na página.
// Foi adicionada uma melhoria para aceitar vírgulas (,) como separador decimal.

function calcularGastoCalorico() {
    // 1. Captura de Dados do Formulário HTML e Tratamento de Vírgulas
    // Usamos document.getElementById() para acessar os elementos pelo seu ID.
    // Adicionamos .replace(',', '.') para trocar vírgulas por pontos antes da conversão para número.
    const idade = parseInt(document.getElementById('idade').value);

    // Tratamento para peso e altura: substitui vírgula por ponto antes de converter para float
    const peso_kg_str = document.getElementById('peso').value.replace(',', '.');
    const peso_kg = parseFloat(peso_kg_str);

    const altura_cm_str = document.getElementById('altura').value.replace(',', '.');
    const altura_cm = parseFloat(altura_cm_str);

    const genero = document.getElementById('genero').value;
    // O fator de atividade já vem como um número (string convertida para float) do select
    const fator_atividade_str = document.getElementById('atividade').value;
    const fator_atividade = parseFloat(fator_atividade_str);

    // Seleciona o elemento onde o resultado será exibido
    const resultadoDiv = document.getElementById('resultado');

    // 2. Validação Básica dos Dados
    // Verifica se todos os campos obrigatórios foram preenchidos e se os números são válidos.
    if (isNaN(idade) || isNaN(peso_kg) || isNaN(altura_cm) || !genero || !fator_atividade_str) {
        resultadoDiv.innerHTML = "<span style='color: red;'>Por favor, preencha todos os campos corretamente!</span>";
        return; // Sai da função se houver erro
    }

    if (idade <= 0 || peso_kg <= 0 || altura_cm <= 0) {
        resultadoDiv.innerHTML = "<span style='color: red;'>Idade, peso e altura devem ser valores positivos.</span>";
        return;
    }

    // 3. Cálculo da Taxa Metabólica Basal (TMB) usando a Fórmula de Mifflin-St Jeor
    let tmb; // Declara a variável tmb

    if (genero === 'M') {
        tmb = (10 * peso_kg) + (6.25 * altura_cm) - (5 * idade) + 5;
    } else { // genero === 'F'
        tmb = (10 * peso_kg) + (6.25 * altura_cm) - (5 * idade) - 161;
    }

    // 4. Cálculo do Gasto Calórico Total Diário
    const gasto_calorico_total = tmb * fator_atividade;

    // 5. Exibição do Resultado na Página HTML
    // Atualiza o conteúdo HTML da div 'resultado' com o valor calculado.
    // toFixed(2) formata o número para ter 2 casas decimais.
    resultadoDiv.innerHTML = `Seu gasto calórico diário estimado é de: <strong>${gasto_calorico_total.toFixed(2)} calorias</strong>.`;
}