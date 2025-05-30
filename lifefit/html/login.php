<?php
if(isset($_POST['submit'])){



//print_r('Name: ' .  $_POST['nome']);
////print_r('<br>');
///rint_r('Date: '.   $_POST['email']);
////print_r('<br>');
//print_r('Altura: '. $_POST['senha']);


include_once '../conexao.php';
// Captura os dados do formulário
$nome= $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];

$result=mysqli_query($conn ,"INSERT INTO usuario(nome, email, senha) VALUES ('$nome', '$email', '$senha')");

}
?>
















<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIVE FIT - Login/Registro</title>
    <link rel="stylesheet" href="../style/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <header>
        <nav id="navbar">
            <i class="fa-solid fa-dumbbell" id="nav-logo">LIVE-FIT</i>
            <ul id="nav-list">
                <li class="nav-item "><a href="../html/index.php">Inicio</a></li>
                <li class="nav-item"><a href="../html/calculadora.php">Cálculo</a></li>
                <li class="nav-item"><a href="../html/paciente.php">Paciente</a></li>
                <li class="nav-item "><a href="../html/avaliacao.php">Avaliação</a></li> 
            </ul>
        </nav>
    </header>

    <div class="main-content">
        <div class="container <?php echo $form_active_class; ?>">
            <div class="form-box login">
                <form action="../testelogin.php" method="post">
                    <h1>Login</h1>
                    <div id="loginMessage" class="message-area">
                        <?php
                            // Exibe mensagens de login e as limpa
                            if (isset($_SESSION['login_error'])) {
                                echo '<span class="error-message">' . $_SESSION['login_error'] . '</span>';
                                unset($_SESSION['login_error']);
                            }
                            if (isset($_SESSION['login_success'])) {
                                echo '<span class="success-message">' . $_SESSION['login_success'] . '</span>';
                                unset($_SESSION['login_success']);
                            }
                        ?>
                    </div>
                    <div class="input-box">
                        <input type="email" placeholder="email" name="email" required><i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="senha" name="senha" id="loginPassword" required>
                        <i class="fa-solid fa-eye" id="toggleLoginPassword" style="cursor: pointer;"></i>
                    </div>
                    <div class="forgot-link">
                        <a href="#">Esqueceu sua senha?</a>
                    </div>
                    <button type="submit" class="btn" name="submit">Login</button>
                    <p>ou faça login pelas suas plataformas:</p>
                    <div class="social-icons">
                        <a href="#"><i class="fa-brands fa-google"></i></a>
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-github"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                </form>
            </div>

            <div class="form-box register">
                <form action="../html/login.php" method="post">
                    <h1>Registre-se</h1>
                    <div id="mensagemRegistro" class="message-area">
                        
                    </div>
                    <div class="input-box">
                        <input type="text" placeholder="nome" name="nome" value="<?php echo htmlspecialchars($name ?? ''); ?>" required><i class="fa-solid fa-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="email" placeholder="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required><i class="fa-solid fa-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" placeholder="senha" name="senha" id="registerPassword" required>
                        <i class="fa-solid fa-eye" id="toggleRegisterPassword" style="cursor: pointer;"></i>
                    </div>
                    <button type="submit" class="btn" name="submit">Registre-se</button>
                    <p>ou registre-se pelas suas plataformas</p>
                    <div class="social-icons">
                        <a href="#"><i class="fa-brands fa-google"></i></a>
                        <a href="#"><i class="fa-brands fa-facebook"></i></a>
                        <a href="#"><i class="fa-brands fa-github"></i></a>
                        <a href="#"><i class="fa-brands fa-linkedin"></i></a>
                    </div>
                </form>
            </div>

            <div class="toggle-box">
                <div class="toggle-panel toggle-left">
                    <h1>Olá, Bem-vindo</h1>
                    <p>Não possui uma conta?</p>
                    <button class="btn register-btn">Registre-se</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Bem-vindo de volta!</h1>
                    <p>Já possui uma conta?</p>
                    <button class="btn login-btn">Login</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../js/scriptlogin.js"></script>
</body>
</html>