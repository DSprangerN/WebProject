
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.0/css/all.min.css">
<?php
include 'ligaBD.php';
$query = "SELECT * FROM user";
$resultado = mysqli_query($liga,$query);
?>
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css">
<table class="table table-dark table-striped">
    <thead>
        <th>ID</th>
        <th>Nome</th>
        <th>Idade</th>
        <th>Género</th>
        <th>Morada 2</th>
        <th>Data Consulta</th>
        <th>Descrição</th>
    </thead>
    <tbody>
        <?php 
            if(mysqli_num_rows($resultado)>0){
                while($row = mysqli_fetch_assoc($resultado)){  ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nome']; ?></td>
                        <td><?php echo $row['idade']; ?></td>
                        <td><?php echo $row['genero']; ?></td>
                        <td><?php echo $row['data_consulta']; ?></td>
                        <td><?php echo $row['descricao']; ?></td>
                        <td><a href="editaUser.php?id=<?php echo $row['iduser']; ?>"><i class="fa-solid fa-pen-to-square"></i>Editar</a>&nbsp;&nbsp;<a href ="eliminaUser.php?id=<?php echo $row['id']; ?>"><i class="fa-solid fa-trash"></i>Eliminar</a></td>
                    </tr>

            <?php
                }
            }else{
                echo "<tr><td colspan='11'>Não existem dados na tabela</td></tr>";

            }
                
        ?>
    </tbody>
</table>