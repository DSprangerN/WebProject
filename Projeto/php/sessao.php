<!-- Função que verifica a qualquer momento se o utilizador está logado -->

<?php
session_start(); // Inicia a sessão

// Verifica se o utilizador está autenticado
if (!isset($_SESSION['user_id'])) {
    echo 'not_logged_in';
} else {
    echo 'logged_in';
}
?>