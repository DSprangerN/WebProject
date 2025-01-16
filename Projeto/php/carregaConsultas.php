
<!-- Script que vai carregar todas as consultas do utilizador logado -->
<?php
session_start();

include '../php/ligaBD.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    echo json_encode([]);
    exit;
}

$date = $_GET['date'];

// Consulta SQL para obter as consultas do usuário logado na data selecionada
$query = "SELECT nome, TIME(data_consulta) as time, tipo_consulta, nome_profissional, descricao
          FROM consultas 
          WHERE DATE(data_consulta) = ? AND id_registo = ?
          ORDER BY data_consulta ASC";
$stmt = $liga->prepare($query);
$stmt->bind_param("si", $date, $user_id);
$stmt->execute();
$result = $stmt->get_result();

$appointments = [];
while ($row = $result->fetch_assoc()) {
    $appointments[] = [
        'time' => htmlspecialchars($row['time']),
        'tipo_consulta' => htmlspecialchars($row['tipo_consulta']),
        'nome_profissional' => htmlspecialchars($row['nome_profissional']),
        'descricao' => htmlspecialchars($row['descricao'])
    ];
}

echo json_encode($appointments);

// Fechar a ligação com a BD
mysqli_close($liga);
?>