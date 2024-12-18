<?php
// Configurações do banco de dados
$servername = "localhost"; // Alterar se necessário
$username = "root"; // Alterar se necessário
$password = ""; // Alterar se necessário
$dbname = "consultas_medicas";

// Conectar ao banco de dados
$conn = new mysqli($Laragon, $root, $M+1+g+u+e+l1, $consultas_medicas);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se os dados foram enviados pelo formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Receber os dados do formulário
    $nome = $conn->real_escape_string($_POST['nome']);
    $idade = (int)$_POST['idade'];
    $genero = $conn->real_escape_string($_POST['genero']);
    $data_consulta = $conn->real_escape_string($_POST['data_consulta']);
    $descricao = $conn->real_escape_string($_POST['descricao']);

    // Inserir os dados no banco
    $sql = "INSERT INTO consultas (nome, idade, genero, data_consulta, descricao) 
            VALUES ('$nome', $idade, '$genero', '$data_consulta', '$descricao')";

    if ($conn->query($sql) === TRUE) {
        echo "<p style='color: green;'>Consulta registada com sucesso!</p>";
    } else {
        echo "<p style='color: red;'>Erro: " . $sql . "<br>" . $conn->error . "</p>";
    }

    // Fechar a conexão
    $conn->close();
} else {
    echo "<p style='color: red;'>Nenhum dado foi enviado.</p>";
}
?>