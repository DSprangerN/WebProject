<?php
$id = $_GET['id'];

include 'ligaBD.php';
$query = "SELECT * FROM user WHERE iduser = $id";

$resultado = mysqli_query($liga,$query);
if(mysqli_num_rows($resultado)<1){
    echo "<script>alert('Registo inexistente!)";
        "window.location.href='mostraDados.php'</script>";
}
$row = mysqli_fetch_assoc($resultado);


?>



<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>
<body>
<header></header>
    <main>
        <div id="registo" style="width:80%;margin-left: 10%;">
            <form id="form_atualizada" method="POST" action="atualizaDados.php?id=<?php echo $row['iduser']; ?>">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="idnome" class="form-label">Nome:</label>
                        <input type="text" id="idnome" class="form-control" name="ctx_nome" placeholder="Insira o seu nome" required maxlength="40" value = "<?php echo $row['nome']; ?>" >
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="idapelido" class="form-label">Apelido:</label>
                        <input type="text" id="idapelido" class="form-control" name="ctx_apelido" placeholder="Insira o seu apelido" required maxlength="40" value = "<?php echo $row['apelido']; ?>">
                    </div>
                </div>
                <div class="row">
                    <label for="idmorada1" class="form-label">Morada 1:</label><input type="text" id="morada1" class="form-control" name="ctx_morada1" placeholder="Rua da Escola nº 27" required maxlength="80" value = "<?php echo $row['morada1']; ?>">
                </div>
                <div class="row">
                    <label for="idmorada2" class="form-label">Morada 2:</label><input type="text" id="morada2" class="form-control" name="ctx_morada2" placeholder="Apartado 202, Mem Martins, Sintra" maxlength="80" value = "<?php echo $row['morada2']; ?>">
                </div>
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for="idlocal" class="form-label">Localidade:</label>
                        <input type="text" id="idlocal" class="form-control" name="ctx_localidade" placeholder="Insira a sua localidade" required maxlength="40" value = "<?php echo $row['localidade']; ?>">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for="iddistrito" class="form-label">Distrito:</label>
                        <input type="text" id="iddistrito" class="form-control" name="ctx_distrito" placeholder="Insira o seu distrito" required maxlength="40" value = "<?php echo $row['distrito']; ?>">
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <label for="idcp" class="form-label">Código-Postal:</label>
                        <input type="text" id="idcp" class="form-control" name="ctx_cod_postal" placeholder="4569-321" required maxlength="8" value = "<?php echo $row['codpostal']; ?>">
                    </div>
                </div>
                <div class="row">
                    <label for="idemail" class="form-label">Email:</label>
                    <input type="email" id="email" class="form-control" name="ctx_email" placeholder="Insira uma conta de email válida" required maxlength="50" value = "<?php echo $row['email']; ?>">
                </div>
                <div class="row">
                    <label for="idtelef" class="form-label">Telefone:</label>
                    <input type="text" id="idtelef" class="form-control" name="ctx_telef" placeholder="Insira o nº de telefone" required value = "<?php echo $row['telefone']; ?>">
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <label for="idpass" class="form-label">Password:</label>
                        <input type="password" id="idpass" class="form-control" name="ctx_pass" placeholder="Insira uma password" required maxlength="40" minlength="8" value = "<?php echo $row['pass']; ?>">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <label for="idrepass" class="form-label">Reescreva Password:</label>
                        <input type="password" id="idrepass" class="form-control" name="ctx_repass" placeholder="Reescreva a password" required maxlength="40" minlength="8" value = "<?php echo $row['pass']; ?>">
                    </div>
                </div>
                <p style="text-align: center;">
                    <input type="submit" class="btn btn-success" name="btn_regista" value="Atualizar Dados">
                    <input type="reset" class="btn btn-danger" name="btn_reset" value="Limpar Formulário">
                </p>
            </form>
        </div>



    </main>
    <footer></footer>
    
</body>
</html>

<?php mysqli_close($liga); ?>