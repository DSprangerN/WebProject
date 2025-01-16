<?php
session_start(); // Inicia a sessão

// Conexão com a base de dados
include '../php/ligaBD.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo "<script>
            alert('Por favor, faça login para continuar.');
            window.location.href = '../login.html';
          </script>";
    exit;
}

// Obtém os dados do formulário
$nome_profissional = htmlspecialchars($_POST['nome_profissional_saude']);
$tipo_consulta = htmlspecialchars($_POST['tipo_consulta']);
$data_consulta = htmlspecialchars($_POST['data_consulta']);
$descricao = htmlspecialchars($_POST['descricao_consulta']);

// Comando SQL para inserir os dados
$query = "INSERT INTO consultas (nome_profissional, tipo_consulta, data_consulta, descricao, id_registo) 
          VALUES (?, ?, ?, ?, ?)";
$stmt = mysqli_prepare($liga, $query);
mysqli_stmt_bind_param($stmt, "ssssi", $nome_profissional, $tipo_consulta, $data_consulta, $descricao, $user_id);

if (mysqli_stmt_execute($stmt)) {
    // Obter o e-mail do usuário
    $query_email = "SELECT email FROM registos WHERE id_registo = ?";
    $stmt_email = $liga->prepare($query_email);
    $stmt_email->bind_param("i", $user_id);
    $stmt_email->execute();
    $result_email = $stmt_email->get_result();
    $user_email = $result_email->fetch_assoc()['email'];

    // Enviar e-mail de confirmação
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->SMTPSecure = 'tls';
        $mail->Username = 'seu_email@gmail.com'; // Substitua pelo seu e-mail
        $mail->Password = 'sua_senha'; // Substitua pela sua senha
        $mail->Port = 587;

        $mail->setFrom('seu_email@gmail.com', 'MediTech'); // Substitua pelo seu e-mail e nome
        $mail->addAddress($user_email);
        $mail->isHTML(true);
        $mail->Subject = 'Confirmação de Marcação de Consulta';
        $mail->Body = nl2br("Sua consulta foi marcada com sucesso.<br>Muito obrigado.");

        $mail->send();
        echo "<script>
                alert('Consulta marcada com sucesso! Um e-mail de confirmação foi enviado.');
                window.location.href = '../php/proximas_consultas.php';
              </script>";
    } catch (Exception $e) {
        echo "<script>
                alert('Consulta marcada, mas houve um erro ao enviar o e-mail de confirmação: {$mail->ErrorInfo}');
                window.location.href = '../php/proximas_consultas.php';
              </script>";
    }
} else {
    echo "<script>alert('Não foi possível marcar a consulta');</script>";
    echo "<p>Query: " . htmlspecialchars($query) . "<br>Erro: " . htmlspecialchars(mysqli_error($liga)) . "</p>";
    echo "<script>window.location.href='../php/formulario.php';</script>";
}

// Fechar a conexão
mysqli_close($liga);
?>