
<!-- Script com o objectivo de cancelar/ apagar uma consulta,
    exibe uma mensagem e envia um email ao utilizador com a confirmação do cancelamento -->
<?php
session_start();

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

if (isset($_GET['id']) && !empty($_GET['id'])) {
    // Obtém o ID da consulta a ser excluída
    // Garante que o ID seja um número inteiro
    $id = intval($_GET['id']); 

    // Comando SQL para apagar a consulta
    $query = "DELETE FROM consultas WHERE id_consultas = ? AND id_registo = ?";

    // Prepara o comando SQL
    if ($stmt = $liga->prepare($query)) {
        // Vincula os parâmetros (ID da consulta e ID do utilizador) ao comando SQL
        $stmt->bind_param("ii", $id, $user_id);

        // Executa o comando SQL
        if ($stmt->execute()) {
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
                $mail->Username = 'spranger10@gmail.com';
                $mail->Password = 'fyvhloqhpbycistb';
                $mail->Port = 587;

                $mail->setFrom('spranger10@gmail.com', 'MediTech');
                $mail->addAddress($user_email);
                $mail->isHTML(true);
                $mail->Subject = 'Confirmação de Cancelamento de Consulta';
                $mail->Body = nl2br("Sua consulta foi cancelada com sucesso.<br>Muito obrigado.");

                $mail->send();
                echo "<script>
                        alert('Consulta cancelada com sucesso! Um e-mail de confirmação foi enviado.');
                        window.location.href = '../php/proximas_consultas.php'; // Redireciona para a página de alteração de consultas
                      </script>";
            } catch (Exception $e) {
                echo "<script>
                        alert('Consulta cancelada com sucesso, mas houve um erro ao enviar o e-mail de confirmação: {$mail->ErrorInfo}');
                        window.location.href = '../php/proximas_consultas.php'; // Redireciona para a página de alteração de consultas
                      </script>";
            }
        } else {
            // Se ocorrer um erro na execução, exibe uma mensagem de erro
            echo "<script>
                    alert('Erro ao cancelar a consulta.');
                    window.history.back();
                  </script>";
        }

        // Termina o comando SQL
        $stmt->close();
    } else {
        // Caso não consiga preparar a consulta
        echo "<script>
                alert('Erro ao preparar a consulta.');
                window.history.back();
              </script>";
    }
} else {
    // Se o ID da consulta não existir, exibe uma mensagem de erro
    echo "<script>
            alert('ID da consulta inválido.');
            window.history.back();
          </script>";
}

// Fecha a ligação com a base de dados
mysqli_close($liga);
?>