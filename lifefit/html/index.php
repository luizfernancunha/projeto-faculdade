<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>LIVE FIT</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" />
  <link rel="stylesheet" href="../style/style.css" />
</head>

<body>
  <header>
    <nav id="navbar">
      <i class="fa-solid fa-dumbbell" id="nav-logo">LIVE FIT</i>
      <ul id="nav-list">
        <li class="nav-item "><a href="index.php">Inicio</a></li>
        <li class="nav-item"><a href="../html/calculadora.php">Cálculo</a></li>
        <li class="nav-item"><a href="../html/paciente.php">Paciente</a></li>
        <li class="nav-item"><a href="../html/avaliacao.php">Avaliação</a></li> 
        <li class="nav-item"><a href="../html/feedback.php">Feedback</a></li>
        <li><button class="btn-default"><a href="../html/login.php">Login</a></button></li>
      </ul>
    </nav>
  </header>

  <!-- Carrossel -->
  <div class="slider">
    <div class="slides" id="slides">
      <div class="slide"><img src="../Imgs-site/img-1.jpg" alt="Imagem 1" /></div>
      <div class="slide"><img src="../Imgs-site/img-5.jpg" alt="Imagem 2" /></div>
      <div class="slide"><img src="../Imgs-site/img-6.jpg" alt="Imagem 3" /></div>
      <div class="slide"><img src="../Imgs-site/img-4.jpg" alt="Imagem 4" /></div>
    </div>
    <button class="arrow left" onclick="prevSlide()">&#10094;</button>
    <button class="arrow right" onclick="nextSlide()">&#10095;</button>
  </div>

  <!-- Conteúdo principal com imagens e textos lado a lado -->
  <main>
    <section class="content-section">
      <div class="text-content">
        <h1>A importância de fazer exercícios físicos</h1>
        <p>A prática regular de exercícios físicos é um pilar fundamental para uma vida saudável e equilibrada. Seus benefícios vão muito além da estética, impactando diretamente nossa saúde física e mental. Fisicamente, o exercício fortalece o sistema cardiovascular, melhora a capacidade pulmonar, controla o peso, previne doenças crônicas como diabetes e hipertensão, e fortalece ossos e músculos.
        No aspecto mental, a atividade física é uma poderosa ferramenta para combater o estresse, a ansiedade e a depressão, liberando endorfinas que promovem uma sensação de bem-estar. Além disso, contribui para a melhora da qualidade do sono e da função cognitiva.</p>
      </div>
      <img src="../Imgs-site/img-2.jpg" alt="Importância do exercício" class="content-img">
    </section>

    <section class="content-section reverse">
      <div class="text-content">
        <h1>Prevenção de Doenças Crônicas</h1>
        <p>A prevenção de doenças crônicas é um dos maiores desafios e, ao mesmo tempo, uma das maiores oportunidades para a saúde pública global. 
        Condições como diabetes tipo 2, hipertensão, doenças cardíacas e certos tipos de câncer não surgem do dia para a noite; elas se desenvolvem ao longo do tempo, muitas vezes influenciadas por escolhas de estilo de vida.Adotar uma alimentação balanceada, rica em frutas, vegetais e grãos integrais, e pobre em alimentos processados e açúcares, é um passo crucial. A prática regular de exercícios físicos, como já mencionado, é outro pilar essencial.Investir na prevenção não só melhora a qualidade de vida individual, mas também alivia a carga sobre os sistemas de saúde. É um compromisso contínuo com o autocuidado que rende frutos duradouros.</p>
      </div>
      <img src="../Imgs-site/img-9.jpeg" alt="Prevenção de doenças" class="content-img">
    </section>

    <section class="content-section">
      <div class="text-content">
        <h1>Mais Energia no Dia a Dia</h1>
        <p>Conquistar mais energia no dia a dia é um desejo comum e totalmente alcançável, e não depende de soluções mirabolantes, mas sim de hábitos simples e consistentes. A chave reside em otimizar as fontes que abastecem nosso corpo e mente.Começar com uma alimentação nutritiva é fundamental: priorizar alimentos integrais, proteínas magras e gorduras saudáveis fornece o combustível de que precisamos para funcionar bem. A hidratação adequada também é um fator muitas vezes negligenciado, mas crucial para evitar a fadiga. Além disso, a qualidade do sono é insubstituível; um descanso insuficiente mina nossa energia e produtividade.</p>
      </div>
      <img src="../Imgs-site/img-7.jpg" alt="Mais energia" class="content-img">
    </section>
  </main>

  <!-- Rodapé -->
  <div class="serviceacad">
    <h2>Venha conhecer nossa consultoria ou TEL():</h2>
  </div>
  <div class="mapa">
    <iframe id="ma"
      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3986.0133609357927!2d-44.28773852525514!3d-2.5024799381643534!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x7f68d900f12e4fb%3A0x90d84ae668094ada!2sUniversidade%20Ceuma%20-%20Renascen%C3%A7a!5e0!3m2!1spt-BR!2sus!4v1747783004153!5m2!1spt-BR!2sus"
      width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
      referrerpolicy="no-referrer-when-downgrade"></iframe>
  </div>
  <footer class="footer">
    <div class="footer-icons">
      <a href="#"><i style="color: blueviolet;" class="fa-brands fa-instagram fa-2x"></i></a>
      <a href="#"><i style="color: blueviolet;" class="fa-brands fa-facebook fa-2x"></i></a>
      <a href="#"><i style="color: blueviolet;" class="fa-brands fa-tiktok fa-2x"></i></a>
    </div>
    <div><i class="fa-solid fa-dumbbell" id="nav-logo"> FIT LIVE</i></div>
    <p>Copyright 2025 | Dev academia - todos os direitos reservados</p>
  </footer>

  <!-- Botão WhatsApp -->
  <a href="#" class="btn_whatsapp" target="_blank">
    <img src="../Imgs-site/whatssapp.svg" alt="icon-whatsapp">
    <span class="text-span">Agende seu horário</span>
  </a>

  <!-- Script do carrossel -->
 <script src="../js/scriptindex.js"></script>
  
</body>

</html>