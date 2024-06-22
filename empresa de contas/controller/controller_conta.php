<?php
include_once (__DIR__ . '/../model/conta.php');
class controller_conta
{
    function Cadastra_Conta()
    {
        if (isset($_POST['cad-conta']) && !empty($_POST['cad-conta'])) {
            $conta = new Conta(
                0, // id_conta (0 se está criando uma nova conta e o valor será atribuído pelo banco de dados)
                $_POST['id_cliente'], // id_cliente_fk
                $_POST['tipo_de_conta'], // tipo_de_conta
                floatval($_POST['valor']), // valor (convertido para float)
                $_POST['vencimento'], // vencimento
                isset($_POST['data_recebimento']) ? $_POST['data_recebimento'] : null, // data_recebimento (nullable)
                $_POST['descricao'], // descricao
                isset($_POST['exclusao_conta']) ? $_POST['exclusao_conta'] : null, // exclusao_conta (nullable)
                $_POST['forma_pagamento'], // forma_pagamento
                'ativa', // status_conta (valor padrão 'Pendente')
                'pendente' // status_pagamento (valor padrão 'ativo')
            );
            $conta->Cadastrar_conta($conta);
            echo "<script>window.location.href = 'index.php'</script>";
        }
    }
    public static function Get_contas($tipo_de_conta)
    {
        if ($tipo_de_conta === "receita") {
            return Conta::Exibir_conta("receita");
        } elseif ($tipo_de_conta === "despesa_fixa") {
            return Conta::Exibir_conta("despesa_fixa");
        } else {
            return Conta::Exibir_conta("despesa_variavel");
        }
    }

    public static function Apagar_Pagar_conta()
    {

        if (isset($_POST['pagar-conta'])) {
            $result = Conta::Paga_conta($_POST['idcontapaga']);
            if ($result) {
                echo "<html> <head></head><body>
                <script>
                alert('Pagamento realizado com sucesso!')
                window.location.href = 'index.php';
                </script>
                </body>
                </html>";
            } else {
                echo "<html> <head></head><body>
                <script> alert('Erro ao realizar pagamento');
                </script>
                </body>
                </html>";
            }
        } elseif (isset($_POST['apagar-conta'])) {
            $result = Conta::Apaga_conta($_POST['idcontadel']);
            if ($result) {
                echo "<html> <head></head><body>
                    <script> alert('Conta excluida com sucesso!')
                    window.location.href = 'index.php';
                    </script>
                    </body>
                    </html>";
            } else {
                echo "<html> <head></head><body>
                    <script> alert('Erro ao excluir pagamento')
                    </script>
                    </body>
                    </html>";
            }
        }
    }

    public static function Exibe_saldo()
    {
        $resultado = Conta::Calcula_saldo();

        $saldo = 0;
        foreach ($resultado as $res) {
            $tipo_de_conta = $res['tipo_de_conta'];
            $valor = $res['valor'];

            if ($tipo_de_conta == 'receita') {
                $saldo = $saldo + $valor;
            }

            if ($tipo_de_conta == 'despesa_fixa') {
                $saldo = $saldo - $valor;

            }

            if ($tipo_de_conta == 'despesa_variavel') {
                $saldo = $saldo - $valor;

            }
        }
        echo $saldo;
    }

    public static function Exibe_despesa_pendente()
    {
        $resultado = Conta::Calcula_despesa_pendente();

        $saldo_a_pagar = 0;

        foreach ($resultado as $res) {
            $tipo_de_conta = $res['tipo_de_conta'];
            $valor = $res['valor'];

            if ($tipo_de_conta == 'despesa_fixa') {
                $saldo_a_pagar = $saldo_a_pagar - $valor;

            }

            if ($tipo_de_conta == 'despesa_variavel') {
                $saldo_a_pagar = $saldo_a_pagar - $valor;

            }


        }
        echo $saldo_a_pagar;
    }
    public static function Exibe_receita_pendente()
    {
        $resultado = Conta::Calcula_receita_pendente();
        $saldo_a_receber = 0;

        foreach ($resultado as $res) {
            $valor = $res['valor'];

            $saldo_a_receber = $saldo_a_receber + $valor;
        }
        echo $saldo_a_receber;
    }

    public static function Ajuste_receita_despesa()
    {
        $data = Conta::Receita_despesa();
        $receitas = [];
        $despesas = [];

        // Percorre o array original e distribui os valores nos arrays correspondentes
        foreach ($data as $item) {
            if ($item['tipo_de_conta'] === 'receita') {
                $receitas[] = $item;
            } else {
                $despesas[] = $item;
            }
        }

        // Função para ordenar arrays pelo campo 'mes_ano' (ano crescente, mês crescente)
        function ordenarPorMesAno($a, $b)
        {
            $mesAnoA = explode('-', $a['mes_ano']);
            $mesAnoB = explode('-', $b['mes_ano']);

            // Compara o ano primeiro
            $resultadoAno = strcmp($mesAnoA[0], $mesAnoB[0]);
            if ($resultadoAno != 0) {
                return $resultadoAno;
            }

            // Se os anos forem iguais, compara o mês
            return strcmp($mesAnoA[1], $mesAnoB[1]);
        }

        // Ordena o array de receitas pelo campo 'mes_ano'
        usort($receitas, 'ordenarPorMesAno');

        // Ordena o array de despesas pelo campo 'mes_ano'
        usort($despesas, 'ordenarPorMesAno');

        return ['receitas' => $receitas, 'despesas' => $despesas];
        // Exibe os arrays ordenados
        
    }
}