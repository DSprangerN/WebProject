
<?php

// Função para fazer o log out do user e fechar a sua conta
// reencaminha o user para a página de login.html para um login diferente ou novo registo de user

session_start();
session_destroy();
header("Location: ../login.html");
exit();

?>