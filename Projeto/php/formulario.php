
<!-- Script da página principal do projeto onde é possivel marcar consultas após o login efetuado -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meditech</title>
    <link rel="stylesheet" href="../CSS/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<style>
    .info-iframe {
        display: none;
        position: fixed;
        bottom: 120px;
        right: 20px;
        width: 30%;
        height: 40%;
        border: none;
        overflow-y: auto;
        z-index: 999;
    }

    .info-button {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 1000;
        background-color: transparent;
        border: none;
        cursor: pointer;
        width: 8%;
        height: auto;
        border-radius: 15px 15px 15px;
        overflow: hidden;
    }
    
    .info-button:hover {
        background-color: #4CAF50;
    }

    .info-button img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .question {
        cursor: pointer;
        padding: 10px;
        border: 1px solid #ccc;
        margin-bottom: 5px;
        background-color: #f8f9fa;
    }

    .answer {
        display: none;
        padding: 10px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        background-color: #e9ecef;
    }

    @media (max-width: 400px) {
        .info-iframe {
            width: 80%;
            height: 50%;
            bottom: 100px;
            right: 10%;
        }

        .info-button {
            width: 15%;
        }
    }
    .header-buttons button {
        width: 30%;
        background-color: #4CAF50;
        color: white;
        font-size: 18px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 4px 2px;
        transition-duration: 0.4s;
    }

    .header-buttons button:hover {
        background-color: #a04545;
        color: white;
    }
</style>

<header>
    <h1>MediTech - Marcação e Gestão de Consultas Médicas Online</h1>
    <div class="header-buttons">
        <button type="button" class="btn-equipa">Equipa Médica</button>
        <button type="button" class="btn-contactos">Contactos</button>
    </div>
    <br>
</header>

<body>
    <a href="../php/logout.php" class="btn btn-danger logout-button">Log Out</a>
    <br>

    <div id="formulario">
        <!-- Formulário para agendar consultas -->
        <form action="../php/validaDados.php" method="post">
            <h1>Agendar Consulta</h1>
            <br>
            <label for="nome_profissional_saude">Nome do Profissional de Saúde:</label>
            <select id="nome_profissional_saude" name="nome_profissional_saude" required>
                <option value="">Escolha o Profissional de Saúde:</option>
                <option value="Jorge Mendes">Jorge Mendes</option>
                <option value="Ana Silva">Ana Silva</option>
                <option value="Ricardo Mendes">Ricardo Mendes</option>
                <option value="Duarte Antunes">Duarte Antunes</option>
                <option value="Rita Ferreira">Rita Ferreira</option>
                <option value="Carlos Silva">Carlos Silva</option>
                <option value="Tiago Neves">Tiago Neves</option>
            </select>
            <label for="tipo_consulta">Tipo de Consulta:</label>
            <select id="tipo_consulta" name="tipo_consulta" required>
                <option value="">Selecione o tipo de consulta</option>
                <option value="Rotina_Preventiva">Consulta de Rotina ou Preventiva</option>
                <option value="Diagnostico">Consulta de Diagnóstico</option>
                <option value="Seguimento">Consulta de Seguimento</option>
                <option value="Urgencia_Emergencia">Consulta de Urgência ou Emergência</option>
                <option value="Especializada">Consulta Especializada</option>
                <option value="Pediatrica">Consulta Pediátrica</option>
                <option value="Geriatrica">Consulta Geriátrica</option>
                <option value="Teleconsulta">Teleconsulta (Consulta Online)</option>
                <option value="Pre_Natal">Consulta Pré-Natal</option>
                <option value="Medicina_Ocupacional">Consulta de Medicina Ocupacional</option>
                <option value="Segunda_Opiniao">Consulta de Segunda Opinião</option>
                <option value="Psicologica_Psiquiatrica">Consulta Psicológica ou Psiquiátrica</option>
                <option value="Domiciliar">Consulta Domiciliar</option>
                <option value="Urgencias_Odontologicas">Consulta de Urgências Odontológicas</option>
            </select>
            <label for="data_consulta">Data da Consulta:</label>
            <input type="datetime-local" id="data_consulta" name="data_consulta" required>
            <label for="descricao_consulta">Descrição da Consulta:</label>
            <textarea id="descricao_consulta" name="descricao_consulta" rows="4" required placeholder="Máximo de 500 caracteres"></textarea>
            <button type="submit" class="btn-regista">Marcar Consulta</button>
            <button type="button" class="btn-altera" onclick="window.location.href='../php/proximas_consultas.php'">Próximas Consultas</button>
            <button type="button" class="btn-calendario" onclick="window.location.href='../php/calendario.php'">Calendário de Consultas</button>
            <button type="button" class="btn-historico" onclick="window.location.href='../php/historico_consulta.php'">Histórico de Consultas</button>
        </form>

        <!-- Iframe para as perguntas + frequentes -->
        <iframe class="info-iframe" id="infoIframe" src="../HTML/info.html"></iframe>
    </div>

    <!-- Botão para abrir o iframe -->
    <button class="info-button" onclick="toggleInfo()">
        <img src="../img/info-icon.png" alt="Info">
    </button>

    <script>
        function toggleInfo() {
            var iframe = document.getElementById('infoIframe');
            if (iframe.style.display === 'none' || iframe.style.display === '') {
                iframe.style.display = 'block';
            } else {
                iframe.style.display = 'none';
                // Reseta o conteúdo do iframe para fechar as respostas
                iframe.contentWindow.location.reload();
            }
        }
    </script>
</body>

<footer>
    <h1>Projeto desenvolvido pelos alunos:<br>
    David das Neves e Miguel Silva<br>
    Professor Marco Tereso<br>
    Tecnologias & Programação de Sistemas de Informação<br>
    ISLA - Santarém - 2024/2025</h1>
</footer>

</html>