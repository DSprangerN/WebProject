<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registo de Consultas Médicas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f7f7f7;
        }

        form {
            max-width: 400px;
            padding: 20px;
            background-color: #ffffff;
            border: 1px solid #cccccc;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }

        input,
        textarea,
        select,
        button {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #cccccc;
            border-radius: 4px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .btn-edit {
            background-color: #007BFF;
        }

        .btn-edit:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Registo de Consultas Médicas</h1>
    <form action="processar_consulta.php" method="post">
        <input type="hidden" id="id" name="id" value=""> <!-- Campo oculto para ID -->

        <label for="nome">Nome do Paciente:</label>
        <input type="text" id="nome" name="nome" required>

        <label for="idade">Idade:</label>
        <input type="number" id="idade" name="idade" required>

        <label for="genero">Gênero:</label>
        <select id="genero" name="genero" required>
            <option value="">Selecione</option>
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
            <option value="Outro">Outro</option>
        </select>

        <label for="data_consulta">Data da Consulta:</label>
        <input type="date" id="data_consulta" name="data_consulta" required>

        <label for="descricao">Descrição da Consulta:</label>
        <textarea id="descricao" name="descricao" rows="4" required></textarea>

        <button type="submit">Registar Consulta</button>
        <button type="submit" class="btn-edit" formaction="editar_consulta.php">Editar Consulta</button>
    </form>
</body>

</html>
