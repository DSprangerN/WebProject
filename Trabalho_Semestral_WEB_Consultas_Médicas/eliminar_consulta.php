<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "consultas_medicas";

// Conectar ao banco
$conn = new mysqli($Laragon, $root, $consultas_medicas);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

// Verificar se o ID foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];

    // Excluir registro
    $sql = "DELETE FROM consultas WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Consulta eliminada com sucesso!";
    } else {
        echo "Erro ao eliminar: " . $conn->error;
    }
}
$conn->close();
?>