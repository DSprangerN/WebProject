<?php

$id = $_GET['id'];
include 'ligaBD.php';

$query = "DELETE FROM user WHERE iduser = $id";

if(mysqli_query($liga,$query)){
    echo "<script>alert('Registo eiminado com sucesso!');
        window.location.href='mostraDados.php'</script>";
}else{
    echo "Erro: ".mysqli_error($liga)."<br>Query: ".$query;
    echo "<script>alert('Não foi possível remover o registo!');
    window.location.href='mostraDados.php'</script>";
}


?>