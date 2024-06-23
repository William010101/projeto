<?php
session_start();

if (!empty($_SESSION['id_usuario'])) {
    // O login foi feito, permanece na página
} else {
    // Redireciona para a página de login se não estiver logado
    header("Location: index.php");
    exit();
}
include_once ('controller/controller_cliente.php');
$controller = new Controller_cliente();
$controller->Excluir_Cliente();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rota Financeira</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="css/style.css">
    <script>
        function limpa_formulário_cep() {
            document.getElementById('rua').value = ("");
            document.getElementById('bairro').value = ("");
            document.getElementById('cidade').value = ("");
            document.getElementById('uf').value = ("");
        }

        function meu_callback(conteudo) {
            if (!("erro" in conteudo)) {
                document.getElementById('rua').value = (conteudo.logradouro);
                document.getElementById('bairro').value = (conteudo.bairro);
                document.getElementById('cidade').value = (conteudo.localidade);
                document.getElementById('uf').value = (conteudo.uf);

            } else {
                limpa_formulário_cep();
                alert("CEP não encontrado.");
            }
        }

        function pesquisacep(valor) {

            var cep = valor.replace(/\D/g, '');

            if (cep != "") {

                var validacep = /^[0-9]{8}$/;

                if (validacep.test(cep)) {

                    document.getElementById('rua').value = "...";
                    document.getElementById('bairro').value = "...";
                    document.getElementById('cidade').value = "...";
                    document.getElementById('uf').value = "...";

                    var script = document.createElement('script');

                    script.src = 'https://viacep.com.br/ws/' + cep + '/json/?callback=meu_callback';

                    document.body.appendChild(script);

                } else {

                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                limpa_formulário_cep();
            }
        };
        
    
    </script>

</head>

<body>
    <header>
        <img src="ROTA financeira.png" alt="">
    </header>

    <?php include_once('includes/extrato.php'); ?>
        
        <div class="segura_tabela">
        <div class="registros">
                <div class="navegacao">
                <form class="tipo" action="#" method="get">
                <div class="nome_da_pagina" <?php echo basename($_SERVER['SCRIPT_NAME']) == 'receitas.php' ? "id='pag-ativa'" : ""; ?>>
                    <?php echo "<a href='receitas.php'>"; ?>
                    <input name="pagina" type="button" value="Receita"<?php echo basename($_SERVER['SCRIPT_NAME']) == 'receitas.php' ? "id='pag-ativa'" : ""; ?>/>
                    <?php echo "</a>"; ?>
                    </div>
                <div class="nome_da_pagina" <?php echo basename($_SERVER['SCRIPT_NAME']) == 'despesaf.php' ? "id='pag-ativa2'" : ""; ?>>
                    <?php echo "<a href='despesaf.php'>"; ?>
                    <input name="pagina" type="button" value="Despesa Fixa" <?php echo basename($_SERVER['SCRIPT_NAME']) == 'despesaf.php' ? "id='pag-ativa2'" : ""; ?>/>
                    <?php echo "</a>"; ?>
                    </div>
                <div class="nome_da_pagina" <?php echo basename($_SERVER['SCRIPT_NAME']) == 'despesav.php' ? "id='pag-ativa3'" : ""; ?>>
                    <?php echo "<a href='despesav.php'>"; ?>
                    <input name="pagina" type="button" value="Despesa Variável" <?php echo basename($_SERVER['SCRIPT_NAME']) == 'despesav.php' ? "id='pag-ativa3'" : ""; ?>/>
                    <?php echo "</a>"; ?>
                    </div>
                <div class="nome_da_pagina" <?php echo basename($_SERVER['SCRIPT_NAME']) == 'clientes.php' ? "id='pag-ativa4'" : ""; ?>>
                    <?php echo "<a href='clientes.php'>"; ?>
                    <input name="pagina" type="button" value="Clientes" <?php echo basename($_SERVER['SCRIPT_NAME']) == 'clientes.php' ? "id='pag-ativa4'" : ""; ?>/>
                    <?php echo "</a>"; ?>
                    </div>
                </form>
            </div>

            <div class="fora4" id="tabela">
                <div class="marg">
                    <div class="expor" id="cabecalho">
                        <div class="inforeg">Nome</div>
                        <div class="inforeg">CPF/CNPJ</div>
                        <div class="inforeg">Cidade</div>
                        <div class="inforeg">Telefone</div>
                        <div class="inforeg">Banco</div>
                        <div class="inforeg">Conta</div>
                        <div class="inforeg">
                            <div class="hidden">1</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="fora4">
                <?php
                $clientes = $controller->Get_Clientes();
                foreach ($clientes as $cli):
                    ?>
                    <div class='marg'>
                        <div class='fora5'>
                                <div class='inforeg3'>
                                    <?php echo $cli->getNome(); ?>
                                </div>
                                <div class='inforeg3'>
                                    <?php echo $cli->getCpfCnpj(); ?>
                                </div> 
                                <div class='inforeg3'>
                                    <?php echo $cli->getCidade(); ?>
                                </div>
                                <div class='inforeg3'>
                                    <?php echo $cli->getTelefone(); ?>
                                </div>
                                <div class='inforeg3'>
                                    <?php echo $cli->getBanco(); ?>
                                </div>
                                <div class='inforeg3'>
                                    <?php echo $cli->getTipoConta(); ?>
                                </div>
                                <div class='inforeg3'>
                                    <form id="apagar" name="apagar" method='POST'>
                                        <button type="submit" name="apagar-cliente" class='pagar' id='excluir'>
                                            <input type='hidden' name='opcao' value='<?php echo $cli->getIDcliente(); ?>'>
                                            Excluir
                                                <i class="fa fa-minus-circle" style="font-size:15px; margin-left:5px" ;=""></i>
                                        </button>
                                    </form>
                                </div>
                        </div>
                    </div>
                <?php endforeach; ?>

            </div>
        </div>
    </div>

    <?php include_once ('includes/formulario_cadastro.php') ?>

</body>

</html>