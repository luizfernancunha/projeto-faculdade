<?php

include_once '../conexao.php';


$sql = "SELECT * FROM avaliacao ORDER BY idavaliacao desc" ;


$result = $conn->query ($sql);



?>








<!--php aqui minuto (0:48)-->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - GN</title>
    <link rel="stylesheet" href="../style/SISTEMA.css">
</head>
<body>

    <div class="container">
        <div class="user-data-box">
            <h2>Dados do Usuário</h2>
            <div class="table-responsive">
                <table class="table text-white table-bg">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Data-Avaliação</th>
                            <th scope="col">Plano de Exercícios</th>
                            <th scope="col">Plano Alimentar</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        
     <?php
          while($user_data= mysqli_fetch_assoc($result))
          {
            echo"<tr>";
            echo "<td>".$user_data['idavaliacao']."</td>";
            echo "<td>".$user_data['nome']."</td>";
            echo "<td>".$user_data['dataAvaliacao']."</td>";
            echo "<td>".$user_data['PlanoExercicios']."</td>";
            echo "<td>".$user_data['PlanoAlimentar']."</td>";
            echo "<td>acoes</td>";
          }



     ?>                 
        </tbody>
                </table>
            </div>
        </div>
    </div>
    
</body>
</html>