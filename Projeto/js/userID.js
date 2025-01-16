
// Função para verificar se o utilizador está autenticado
function verificaID() {
    $.ajax({
        url: '../php/sessao.php',
        type: 'GET',
        success: function (response) {
            if (response === 'not_logged_in') {
                alert('Por favor, faça login para continuar.');
                window.location.href = '../login.html';
            }
        },
        error: function () {
            alert('Erro ao verificar a sessão. Por favor, tente novamente.');
        }
    });
}

// Chama a função para verificar a sessão quando a página é carregada
$(document).ready(function () {
    verificaID();
});