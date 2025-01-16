<?php
session_start(); // Inicia a sessão

// Conexão com a base de dados
include 'ligaBD.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo "<script>
            alert('Por favor, faça login para continuar.');
            window.location.href = '../login.html';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MediTech</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        .content-wrapper {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<header>
    <h1>MediTech - Marcação e Gestão de Consultas Médicas Online</h1>
</header>

<body style="background-color: #f8f9fa;">
    <a href="../php/formulario.php" class="btn btn-primary home-button">Home</a>
    <a href="../php/logout.php" class="btn btn-danger logout-button">Log Out</a>
    <div class="container mt-5">
        <div class="content-wrapper">
            <h1 class="mb-4">Próximas Consultas</h1>

            <?php
            $dataAtual = date("Y-m-d");

            // Comando SQL para obter as consultas futuras do utilizador autenticado com data ascendente
            $query = "SELECT * FROM consultas WHERE data_consulta >= ? AND id_registo = ? ORDER BY data_consulta ASC";
            
            // Prepara e executa o comando SQL
            $stmt = $liga->prepare($query);
            $stmt->bind_param("si", $dataAtual, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verifica se há registos na tabela
            if ($result->num_rows > 0) {
                // Se houver registros, cria uma tabela HTML para exibi-los
                echo '<table class="table table-hover">';
                echo '<thead class="table-dark">';
                echo '<tr>';
                echo '<th scope="col">Profissional de Saúde</th>';
                echo '<th scope="col">Tipo de Consulta</th>';
                echo '<th scope="col">Data</th>';
                echo '<th scope="col">Descrição</th>';
                echo '<th scope="col">Ações</th>';
                echo '</tr>';
                echo '</thead>';
                echo '<tbody>';

                // Loop para percorrer os registos da consulta
                while ($row = $result->fetch_assoc()) {
                    echo '<tr>';

                    // Exibe os dados de cada coluna para cada consulta
                    echo '<td>' . htmlspecialchars($row['nome_profissional']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['tipo_consulta']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['data_consulta']) . '</td>';
                    echo '<td>' . htmlspecialchars($row['descricao']) . '</td>';

                    // Adiciona os botões "Alterar" e "Cancelar"
                    echo '<td>';
                    echo '<a href="editar_consulta.php?id=' . htmlspecialchars($row['id_consultas']) . '" class="btn btn-primary btn-sm">Alterar</a> ';
                    echo '<a href="cancelar_registo.php?id=' . htmlspecialchars($row['id_consultas']) . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Tem certeza que deseja cancelar esta consulta?\')">Cancelar</a>';
                    echo '</td>';

                    echo '</tr>';
                }

                echo '</tbody>';
                echo '</table>';
            } else {
                // Se não houver registros, exibe uma mensagem de aviso
                echo '<p class="alert alert-warning">Nenhuma consulta futura encontrada.</p>';
            }

            // Fecha a conexão com a base de dados
            $stmt->close();
            mysqli_close($liga);
            ?>
        </div>
    </div>
</body>

<footer>
    <h1>Projeto desenvolvido pelos alunos:<br>
        David das Neves e Miguel Silva<br>
        Professor Marco Tereso<br>
        Tecnologias & Programação de Sistemas de Informação<br>
        ISLA - Santarém - 2024/2025</h1>
</footer>

</html>