<?php

$id = $_GET['id'];

//obter dados do formulário
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$genero = $_POST['genero'];
$data_consulta = $_POST['data_consulta'];
$descricao = $_POST['descricao'];

include 'ligaBD.php';
$query = "UPDATE user SET nome='$nome', idade='$idade', genero='$genero', data_consulta='$data_consulta', descricao='$descricao', WHERE iduser=$id";

if(mysqli_query($liga,$query)){
    echo"<script>alert('Registo atualizado com sucesso!'); </script>";
    echo"<script>window.location.href='mostraDados.php'</script>";
}else{
    echo"<script>alert('Não foi possível inserir o registo!'); </script>";
    echo"Query: ".$query."<br>Erro:".mysqli_error($liga);
    echo"<script>window.location.href='mostraDados.php'</script>";
}

mysqli_close($liga); 

?>