
<!-- Script para criar um calendário interativo que ao selecionar o dia com consulta mostre as informações dessa consulta
    A função session_start() garante que o utilizador está com o login efetuado -->

<?php
session_start();

include '../php/ligaBD.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo "<script>
            alert('Por favor, faça login para continuar.');
            window.location.href = '../login.html';
          </script>";
    exit;
}

// Consulta SQL para obter as datas das consultas
$query = "SELECT DATE(data_consulta) as data_consulta FROM consultas WHERE id_registo = ?";
$stmt = $liga->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$consultas = [];
while ($row = $result->fetch_assoc()) {
    $consultas[] = $row['data_consulta'];
}

mysqli_close($liga);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meditech</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <style>
        .content-wrapper {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 60%;
            margin: auto;
        }

        .content {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .calendar-container {
            width: 35%;
            margin-left: 15%;
        }

        .appointments-container {
            width: 65%;
            border-left: 2px solid #ccc;
            padding-left: 20px;
        }

        h1 {
            text-align: center;
        }

        @media (max-width: 768px) {
            .content {
                flex-direction: column;
            }
            .calendar-container, .appointments-container {
                width: 100%;
            }
            .appointments-container {
                border-left: none;
                border-top: 2px solid #ccc;
                padding-left: 0;
                padding-top: 20px;
            }
        }
    </style>
</head>

<header>
    <div class="header-content">
        <h1>MediTech - Marcação e Gestão de Consultas Médicas Online</h1>
    </div>
</header>

<body style="background-color: #f8f9fa;">

    <a href="../php/formulario.php" class="btn btn-primary home-button">Home</a>
    <a href="../php/logout.php" class="btn btn-danger logout-button">Log Out</a>

    <div class="container mt-5">
        <div class="content-wrapper">
            <h1 class="mb-4">Calendário de Consultas</h1>
            <div class="content">
                <div class="calendar-container">
                    <div id="calendar"></div>
                </div>
                <div class="appointments-container">
                    <ul id="appointments-list" class="list-group"></ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var consultas = <?php echo json_encode($consultas); ?>;

            // Função calendário
            $('#calendar').datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                autoclose: true,
                beforeShowDay: function(date) {
                    var dateString = date.toISOString().split('T')[0];
                    if (consultas.includes(dateString)) {
                        return {classes: 'highlight'};
                    }
                    return;
                }
            }).on('changeDate', function(e) {
                // Obtém a data selecionada
                var selectedDate = e.format();
                // Faz uma requisição AJAX para carregar as consultas da data selecionada
                $.ajax({
                    url: '../php/carregaConsultas.php',
                    type: 'GET',
                    data: { date: selectedDate },
                    success: function(data) {
                        // Converte a resposta JSON em um array de consultas
                        var appointments = JSON.parse(data);
                        var appointmentsList = $('#appointments-list');
                        // Limpa a lista de consultas
                        appointmentsList.empty();
                        // Verifica se há consultas para a data selecionada
                        if (appointments.length > 0) {
                            // Adiciona cada consulta à lista
                            appointments.forEach(function(appointment) {
                                appointmentsList.append(
                                    '<li class="list-group-item">' +
                                    '<strong>Hora:</strong> ' + appointment.time + '<br>' +
                                    '<strong>Tipo:</strong> ' + appointment.tipo_consulta + '<br>' +
                                    '<strong>Médico:</strong> ' + appointment.nome_profissional + '<br>' +
                                    '<strong>Descrição:</strong> ' + appointment.descricao +
                                    '</li>'
                                );
                            });
                        } else {
                            // Adiciona uma mensagem indicando que não há consultas
                            appointmentsList.append('<li class="list-group-item">Nenhuma consulta encontrada.</li>');
                        }
                    }
                });
            });
        });
    </script>

    <style>
        .highlight {
            background-color: green !important;
            color: white;
        }
    </style>

</body>

<footer>
    <h1>Projeto desenvolvido pelos alunos:<br>
        David das Neves e Miguel Silva<br>
        Professor Marco Tereso<br>
        Tecnologias & Programação de Sistemas de Informação<br>
        ISLA - Santarém - 2024/2025</h1>
</footer>

</html>