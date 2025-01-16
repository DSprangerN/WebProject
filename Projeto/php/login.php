
<!-- script que confirma que o utilizador a fazer login está de registado na base de dados com o email e password correctos -->

<?php
session_start();

include 'ligaBD.php';

// Obtém os dados do formulário de login
$email = $_POST['email'];
$password = $_POST['password'];

// Prepara a consulta SQL para verificar se o usuário existe
$query = "SELECT * FROM registos WHERE email = ? AND password = ?";
$stmt = mysqli_prepare($liga, $query);
mysqli_stmt_bind_param($stmt, "ss", $email, $password);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) > 0) {
    // Usuário existe, inicia a sessão e redireciona para formulario.php
    $user = mysqli_fetch_assoc($result);
    $_SESSION['user_id'] = $user['id_registo'];
    echo "<script>
            alert('Login efetuado com sucesso!');
            window.location.href='../php/formulario.php';
          </script>";
} else {
    // Usuário não existe, exibe mensagem de erro e redireciona para login.html
    echo "<script>
            alert('Este login não existe, por favor efetue o registo primeiro. Obrigado');
            window.location.href='../login.html';
          </script>";
}

// Fechar a ligação com BD
mysqli_close($liga);
?>