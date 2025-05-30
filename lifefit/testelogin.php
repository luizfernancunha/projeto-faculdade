<?php


//print_r($_REQUEST)
if(isset($_POST['submit'])&& !empty($_POST['email']) && !empty($_POST['senha']))
{
    //acessando dados do registro
    include_once 'conexao.php';

    $email = $_POST['email'];
    $senha = $_POST['senha'];

   // print_r('Email:' . $email);
   // print_r('senha:' . $senha);

$sql = "SELECT * FROM usuario WHERE email='$email' AND senha='$senha'";
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) < 1)
    {
        //Não acessa
       
        header('Location: ./html/login.php');
    }
    else
    {
        //Acessa
        header('Location: ./html/index.php');
    }





}

else
{
    //Não acessa
 header('Location: ../html/login.php');
}

?>