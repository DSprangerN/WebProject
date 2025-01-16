<!-- Script que vai permitir o acesso à base de dados 'consultas' através das variáveis definidas
 caso não seja possivel, exibe uma mensagem com o erro e redireciona o utilizador para a página de login/ registo -->

<?php

// Variáveis
$servername = "localhost";
$user = "root";
$passwd = "Prisonbreak10";
$bd = "consultas";

$liga = mysqli_connect($servername, $user, $passwd, $bd);

// Verifica a ligação
if(!$liga){
    echo "<script> alert('A Ligação com a base de dados falhou'); </script>";
    echo "Erro: ".mysqli_connect_error();
    echo "<script> window.location.href='../login.html'; </script>";
}

?>