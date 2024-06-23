<?php
include_once('model/usuarios.php');

if (isset($_POST['login'])) {
    // Proteção contra SQL Injection
    $email = $_POST['login'];
    $senha = $_POST['senha'];

    if (Usuario::logar($email, $senha)) {
        header('Location: receitas.php');
        exit(); // Certifique-se de terminar o script após redirecionar
    } else {
        var_dump(Usuario::logar($email, $senha));
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rota Financeira</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/index.css">
</head>

<body>
    <form method="POST" class="fundo-formulario">
        <div class="login">Login</div>
        <div class="segura-input">
            <input type="email" name="login" id="" placeholder="E-mail" required="">
            <input type="password" name="senha" id="" placeholder="Senha" required="">
            <input type="submit" name="btn-logar" value="Entrar">
            <a href="https://chat.whatsapp.com/LNGfUTRfgSsD7cS7faLO2c" class="contato">Entre em contato</a>
        </div>
    </form>
    <div class="informacoes">
        <div class="logo"><img src="rota.png" alt=""></div>
        <div class="titulo">Sistema de Gestão Financeira Empresarial</div>
        <div class="linha"></div>
        <div class="texto-sistema" id="recuo">Solução inovadora para os desafios financeiros enfrentados por pequenas
            empresas no cenário econômico atual. Focado na gestão financeira eficaz,
            oferece uma abordagem abrangente para ajudar empreendedores a superar obstáculos, proporcionando controle
            preciso sobre despesas, receitas e metas financeiras.
        </div>
    </div>
    <?php
    /*isset verifica se a variavel existe, retorna boolean */

    ?>
</body>

</html>