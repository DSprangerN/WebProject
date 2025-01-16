<?php
session_start(); // Inicia a sessão

// Conexão com a base de dados
include 'ligaBD.php';

// Obtém os dados do registo
$nome = $_POST['nome'];
$idade = $_POST['idade'];
$genero = $_POST['genero'];
$email = $_POST['email'];
$password = $_POST['password'];

// Verifica se o email já existe na base de dados
$check_query = "SELECT * FROM registos WHERE email = ?";
$stmt = mysqli_prepare($liga, $check_query);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
$check_result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($check_result) > 0) {
    // Email já existe, exibe mensagem de erro e redireciona para login.html
    echo "<script>
            alert('Esta conta de email já existe');
            window.location.href='../login.html';
          </script>";
} else {
    // Email não existe, insere os dados na base de dados
    $query = "INSERT INTO registos (nome, idade, genero, email, password) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($liga, $query);
    mysqli_stmt_bind_param($stmt, "sisss", $nome, $idade, $genero, $email, $password);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>
                alert('Registo efetuado com sucesso. Obrigado');
                window.location.href='../login.html';
              </script>";
    } else {
        echo "<script>alert('Não foi possível fazer o registo');</script>";
        echo "<p>Query: " . htmlspecialchars($query) . "<br>Erro: " . htmlspecialchars(mysqli_error($liga)) . "</p>";
        echo "<script>window.location.href='../login.html';</script>";
    }
}

// Fechar a base de dados
mysqli_close($liga);
?>