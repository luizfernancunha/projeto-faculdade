<?php

include_once '../conexao.php';


$sql = "SELECT * FROM usuario ORDER BY idusuario desc" ;


$result = $conn->query ($sql);



?>



























<!--php aqui minuto (0:48)-->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema - GN</title>
    <link rel="stylesheet" href="../style/sistema.css">
</head>
<body>


    <div class="m-5">
        <table class="table text-white table-bg">
        <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Email</th>
                    <th scope="col">Senha</th>
                     <th scope="col">...</th>
                </tr>
        </thead>

        <tbody>
         <!-- luis aqui é php no video (4:00) -->
        <?php
          while($user_data= mysqli_fetch_assoc($result))
          {
            echo"<tr>";
            echo "<td>".$user_data['idusuario']."</td>";
            echo "<td>".$user_data['nome']."</td>";
            echo "<td>".$user_data['email']."</td>";
            echo "<td>".$user_data['senha']."</td>";
            echo "<td>acoes</td>";
          }



        ?>
        </tbody>
</table>
    </div>
    
</body>
</html>