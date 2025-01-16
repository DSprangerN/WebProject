<!-- Este script tem como função verificar o login do utilizador e os seus dados convertendo para o tipo de dados pretendido.
    Através de comandos sql atualiza a base de dados e obtém o email do utilizador inserido no login.
    No final pretende-se que envie um email ao utilizador. -->

<?php
session_start(); // Inicia a sessão

include 'ligaBD.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Função para verificar se o utilizador tem o login feito
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo "<script>
            alert('Por favor, faça login para continuar.');
            window.location.href = '../login.html';
          </script>";
    exit;
}

// Verifica se os dados foram enviados pelo formulário utilizando o método POST e valida os mesmos.
// A função intval converte para inteiro (ou zero se o valor não for um número válido)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = intval($_POST['id']);
    $nome_profissional = htmlspecialchars($_POST['nome_profissional']);
    $tipo_consulta = htmlspecialchars($_POST['tipo_consulta']);
    $data_consulta = htmlspecialchars($_POST['data_consulta']);
    $descricao = htmlspecialchars($_POST['descricao']);

    // Comando SQL
    $query = "
        UPDATE consultas
        SET
            nome_profissional = ?,
            tipo_consulta = ?,
            data_consulta = ?,
            descricao = ?
        WHERE
            id_consultas = ? AND id_registo = ?
    ";

    $stmt = $liga->prepare($query);

    // O método bind_param vincula os parâmetros da consulta (valores fornecidos pelo formulário)
    $stmt->bind_param(
        "ssssii", // Tipos dos parâmetros (s = string, i = inteiro)
        $nome_profissional,
        $tipo_consulta,
        $data_consulta,
        $descricao,
        $id,
        $user_id
    );

    // Executa o comando SQL e obtém o e-mail
    if ($stmt->execute()) {
        
        $query_email = "SELECT email FROM registos WHERE id_registo = ?";
        $stmt_email = $liga->prepare($query_email);
        $stmt_email->bind_param("i", $user_id);
        $stmt_email->execute();
        $result_email = $stmt_email->get_result();
        $user_email = $result_email->fetch_assoc()['email'];

        // Enviar e-mail
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
            $mail->Password = 'ssguwmuntpfallfo';
            $mail->Port= 587;

            $mail->setFrom('spranger10@gmail.com','MediTech');
            $mail->addAddress($user_email);
            $mail->isHTML(true);
            $mail->Subject="Alteração de Consulta";
            $mail->Body = nl2br("Informamos que a sua consulta foi alterada com sucesso!<br>Muito obrigado.");

            $mail->send();
            echo "<script>
                    alert('Consulta atualizada com sucesso!');
                    window.location.href = '../php/proximas_consultas.php';
                  </script>";
        } catch (Exception $e) {
            echo "<script>
                    alert('Consulta atualizada, mas houve um erro ao enviar o e-mail: {$mail->ErrorInfo}');
                    window.location.href = '../php/proximas_consultas.php';
                  </script>";
        }
    } else {
        // Mensagem de erro e volta para a página anterior
        echo "<script>
                alert('Erro ao atualizar a consulta.');
                window.history.back();
              </script>";
    }

    // Fecha a consulta após a execução
    $stmt->close();
} else {
    // Caso o método de solicitação não seja POST, exibe uma mensagem de erro e volta para a página anterior
    echo "<script>
            alert('Método de solicitação inválido.');
            window.history.back();
          </script>";
}

// Fecha a ligação com a base de dados
mysqli_close($liga);
?>