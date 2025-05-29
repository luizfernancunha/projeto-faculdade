<?php
$host = 'localhost'; // Seu host de banco de dados
$db    = 'cadastropaciente'; // Seu nome de banco de dados
$user = 'root'; // Seu nome de usuário do banco de dados
$pass = ''; // Sua senha do banco de dados (deixe em branco se não houver senha)
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $conn = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    die("Erro de conexão com o banco de dados: " . $e->getMessage());
}
?>