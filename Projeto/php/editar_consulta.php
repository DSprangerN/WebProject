
<!-- Script com o objectivo de editar as futuras consultas do utilizador logado -->
<?php
session_start();

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

if (isset($_GET['id'])) {
    $consulta_id = intval($_GET['id']); // Garante que o ID é um número inteiro
} else {
    echo "<script>
            alert('ID da consulta não especificado.');
            window.location.href = 'alterar_registo.php';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meditech</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<style>
        .content-wrapper {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 40%;
            margin: auto;
        }

        .title {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>

<header>
    <h1>MediTech - Marcação e Gestão de Consultas Médicas Online</h1>
</header>

<body style="background-color: #f8f9fa;">

    <a href="../php/formulario.php" class="btn btn-primary home-button">Home</a>
    <a href="../php/logout.php" class="btn btn-danger logout-button">Log Out</a>
    
    <div class="container mt-5">
        <div class="content-wrapper">
        <h1 class="title">Alterar Consulta</h1>
            <?php
            // Comando SQL para obter o registo específico da tabela 'consultas' do utilizador autenticado
            $query = "SELECT * FROM consultas WHERE id_consultas = ? AND id_registo = ?";
            
            // Prepara e executa o comando SQL
            $stmt = $liga->prepare($query);
            $stmt->bind_param("ii", $consulta_id, $user_id);
            $stmt->execute();
            $result = $stmt->get_result();

            // Verifica se há registo na tabela
            if ($row = $result->fetch_assoc()) {
                // Preenche o formulário com os dados do registo da consulta
                echo '<form action="atualiza_consulta.php" method="post">';
                echo '<input type="hidden" id="id" name="id" value="' . htmlspecialchars($row['id_consultas']) . '">';

                echo '<label for="nome_profissional">Nome do Profissional de Saúde:</label>';
                echo '<input type="text" id="nome_profissional" name="nome_profissional" value="' . htmlspecialchars($row['nome_profissional']) . '" required>';

                echo '<label for="tipo_consulta">Tipo de Consulta:</label>';
                echo '<select id="tipo_consulta" name="tipo_consulta" required>';

                $tipos = [
                    "Rotina_Preventiva", "Diagnostico", "Seguimento", "Urgencia_Emergencia", "Especializada",
                    "Pediatrica", "Geriatrica", "Teleconsulta", "Pre_Natal", "Medicina_Ocupacional",
                    "Segunda_Opiniao", "Psicologica_Psiquiatrica", "Domiciliar", "Urgencias_Odontologicas"
                ];

                foreach ($tipos as $tipo) {
                    echo '<option value="' . $tipo . '"' . ($row['tipo_consulta'] == $tipo ? ' selected' : '') . '>' . $tipo . '</option>';
                }
                echo '</select>';

                echo '<label for="data_consulta">Data da Consulta:</label>';
                echo '<input type="datetime-local" id="data_consulta" name="data_consulta" value="' . htmlspecialchars($row['data_consulta']) . '" required>';

                echo '<label for="descricao">Descrição da Consulta:</label>';
                echo '<textarea id="descricao" name="descricao" rows="4" required>' . htmlspecialchars($row['descricao']) . '</textarea>';

                echo '<button type="submit" class="btn btn-primary mt-3">Gravar Alterações</button>';
                echo '</form>';
            } else {

                echo '<p class="alert alert-danger">Consulta não encontrada.</p>';
            }

            // Fecha a ligação com a BD
            $stmt->close();
            mysqli_close($liga);
            ?>

            <!-- Botão para voltar ao formulário -->
            <a href="proximas_consultas.php" class="btn btn-secondary mt-3">Voltar</a>
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