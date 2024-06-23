<?php
include_once('connection.php');

class Conta {
    // Atributos
    private $id_conta; // int (PRIMARY KEY)
    private $id_cliente_fk; // int (FOREIGN KEY)
    private $tipo_de_conta; // string
    private $valor; // float
    private $vencimento; // string (formato date)
    private $data_recebimento; // string (formato datetime, nullable)
    private $descricao; // string
    private $exclusao_conta; // string (formato datetime, nullable)
    private $forma_pagamento; // string
    private $status_conta; // string
    private $status_pagamento; // string

    // Construtor
    public function __construct($id_conta, $id_cliente_fk, $tipo_de_conta, $valor, $vencimento, $data_recebimento = null, $descricao = '', $exclusao_conta = null, $forma_pagamento = '', $status_conta = '', $status_pagamento = '') {
        $this->id_conta = $id_conta;
        $this->id_cliente_fk = $id_cliente_fk;
        $this->tipo_de_conta = $tipo_de_conta;
        $this->valor = $valor;
        $this->vencimento = $vencimento;
        $this->data_recebimento = $data_recebimento;
        $this->descricao = $descricao;
        $this->exclusao_conta = $exclusao_conta;
        $this->forma_pagamento = $forma_pagamento;
        $this->status_conta = $status_conta;
        $this->status_pagamento = $status_pagamento;
    }

    // Getters
    public function getIdConta(): int {
        return $this->id_conta;
    }

    public function getIdClienteFk(): int {
        return $this->id_cliente_fk;
    }

    public function getTipoDeConta(): string {
        return $this->tipo_de_conta;
    }

    public function getValor(): float {
        return $this->valor;
    }

    public function getVencimento(): string {
        return $this->vencimento;
    }

    public function getDataRecebimento(): ?string {
        return $this->data_recebimento;
    }

    public function getDescricao(): string {
        return $this->descricao;
    }

    public function getExclusaoConta(): ?string {
        return $this->exclusao_conta;
    }

    public function getFormaPagamento(): string {
        return $this->forma_pagamento;
    }

    public function getStatusConta(): string {
        return $this->status_conta;
    }

    public function getStatusPagamento(): string {
        return $this->status_pagamento;
    }

    // Setters
    public function setIdConta(int $id_conta): void {
        $this->id_conta = $id_conta;
    }

    public function setIdClienteFk(int $id_cliente_fk): void {
        $this->id_cliente_fk = $id_cliente_fk;
    }

    public function setTipoDeConta(string $tipo_de_conta): void {
        $this->tipo_de_conta = $tipo_de_conta;
    }

    public function setValor(float $valor): void {
        $this->valor = $valor;
    }

    public function setVencimento(string $vencimento): void {
        $this->vencimento = $vencimento;
    }

    public function setDataRecebimento(?string $data_recebimento): void {
        $this->data_recebimento = $data_recebimento;
    }

    public function setDescricao(string $descricao): void {
        $this->descricao = $descricao;
    }

    public function setExclusaoConta(?string $exclusao_conta): void {
        $this->exclusao_conta = $exclusao_conta;
    }

    public function setFormaPagamento(string $forma_pagamento): void {
        $this->forma_pagamento = $forma_pagamento;
    }

    public function setStatusConta(string $status_conta): void {
        $this->status_conta = $status_conta;
    }

    public function setStatusPagamento(string $status_pagamento): void {
        $this->status_pagamento = $status_pagamento;
    }


    public function Cadastrar_conta(Conta $conta):string
    {
        $conexao = new Conexao();
        try{
            $sql="INSERT INTO contas (id_cliente_fk, descricao, vencimento, valor, forma_pagamento, status_pagamento, tipo_de_conta,status_conta) 
                VALUES ('$conta->id_cliente_fk', '$conta->descricao', '$conta->vencimento', '$conta->valor', '$conta->forma_pagamento','$conta->status_pagamento','$conta->tipo_de_conta','$conta->status_conta')";
            $conexao->executarQuery($sql);
            return "Conta cadastrada com sucesso!";
        }catch (PDOException $e) {
            return "Erro ao cadastrar conta: " . $e->getMessage();
        }
    }

    public static function Exibir_conta($tipoconta):array
    {
        $contas = [];
        try{
        $conexao = new Conexao();
        $sql = "SELECT nome, cpf_cnpj, descricao, vencimento, data_recebimento, valor, forma_pagamento, id_contas, id_cliente_fk, status_pagamento 
        FROM contas INNER JOIN cliente on id_cliente_fk = cliente.id_cliente where tipo_de_conta='$tipoconta' AND status_pagamento = 'pendente' OR tipo_de_conta='$tipoconta' AND status_pagamento='pago'";
        $resultado = $conexao->executarQuery($sql);
            if ($resultado->num_rows > 0) {
                
                while ($row = $resultado->fetch_assoc()) {
                    $obj = new stdClass();
                        $obj->nome = $row['nome'];        // 
                        $obj->id_contas = $row['id_contas'];        // 
                        $obj->cpf_cnpj = $row['cpf_cnpj'];// 
                        $obj->descricao = $row['descricao'];     // 
                        $obj->valor = $row['valor']; // 
                        $obj->vencimento = $row['vencimento'];        // 
                        $obj->recebimento = $row['data_recebimento'];  // 
                        $obj->id_cliente_fk = $row['id_cliente_fk'];    // 
                        $obj->forma_pagamento = $row['forma_pagamento'];   // 
                        $obj->status_pagamento = $row['status_pagamento'];   // 
                    
                $contas[] = $obj;    
            }
        }
        $conexao->fecharConexao();   
        }catch(PDOException $e){
            echo "Erro ao exibir conta: " . $e->getMessage();
        }
        return $contas;
    }

    public static function Paga_conta($idconta):bool
    {
        try{
            $conexao = new Conexao();
            date_default_timezone_set('America/Sao_Paulo');
            $datalocal = date('Y/m/d H:i:s');
            $sql = "UPDATE contas SET status_pagamento='pago', status_conta='ativo', data_recebimento='$datalocal' WHERE id_contas=$idconta";
            $conexao->executarQuery($sql);
            
        }catch (PDOException $e){
            echo "Erro ao pagar conta: " . $e->getMessage();
        }
        return true;
    } 

    public static function Apaga_conta($idconta):bool
    {
        try{
            $conexao = new Conexao();
            date_default_timezone_set('America/Sao_Paulo');
            $datalocal = date('Y/m/d H:i:s');
            $sql = "UPDATE contas SET status_conta='inativo',exclusao_conta='$datalocal' WHERE id_contas='$idconta'";
            $conexao->executarQuery($sql);
            
        }catch (PDOException $e){
            echo "Erro ao apagar conta: " . $e->getMessage();
        }
        return true;
    }

    public static function Calcula_saldo():array
    {
        try{
            $conexao = new Conexao();
            $sql="SELECT * FROM contas where status_conta='ativo' && status_pagamento='pago'";
            $resultado = $conexao->executarQuery($sql);
            $dados = [];
            while ($row = mysqli_fetch_assoc($resultado)) {
            $dados[] = $row;
        }
        }catch (PDOException $e){
            echo "Erro ao consultar saldo: " . $e->getMessage();
        }
        return $dados;
    }
    public static function Calcula_despesa_pendente():array
    {
        try{
            $conexao = new Conexao();
            $sql="SELECT * FROM contas where status_conta='ativa' && status_pagamento='pendente'";
            $resultado = $conexao->executarQuery($sql);
            $dados = [];
            while ($row = mysqli_fetch_assoc($resultado)) {
            $dados[] = $row;
        }
        }catch (PDOException $e){
            echo "Erro ao consultar saldo: " . $e->getMessage();
        }
        return $dados;
    }
    public static function Calcula_receita_pendente():array
    {
        try{
            $conexao = new Conexao();
            $sql="SELECT * FROM contas where tipo_de_conta='receita' AND status_conta='ativa' AND status_pagamento='pendente'";
            $resultado = $conexao->executarQuery($sql);
            $dados = [];
            while ($row = mysqli_fetch_assoc($resultado)) {
            $dados[] = $row;
        }
        }catch (PDOException $e){
            echo "Erro ao consultar saldo: " . $e->getMessage();
        }
        return $dados;
    }

    public static function Maior_receita_despesa_cliente(string $query):array
    {
        try{
            $conexao = new Conexao();
            $sql="SELECT cliente.nome, SUM(contas.valor) AS total_valor
            FROM contas
            INNER JOIN cliente ON contas.id_cliente_fk = cliente.id_cliente "
            .$query."
            GROUP BY cliente.nome
            ORDER BY total_valor DESC
            LIMIT 5";
            $resultado = $conexao->executarQuery($sql);
            $dados = [];
            while ($row = mysqli_fetch_assoc($resultado)) {
            $dados[] = $row;
        }
        }catch (PDOException $e){
            echo "Erro ao consultar saldo: " . $e->getMessage();
        }
        return $dados;
    }
    public static function Receita_despesa():array
    {
        try{
            $conexao = new Conexao();
            $sql="SELECT DATE_FORMAT(data_recebimento, '%Y-%m')
            AS mes_ano, tipo_de_conta, SUM(valor) 
            AS valor FROM contas WHERE tipo_de_conta = 'receita' AND status_pagamento='pago' AND data_recebimento IS NOT NULL GROUP BY mes_ano, tipo_de_conta 
            UNION ALL 
            SELECT DATE_FORMAT(data_recebimento, '%Y-%m') 
            AS mes_ano, tipo_de_conta, SUM(valor) 
            AS valor FROM contas 
            WHERE (tipo_de_conta = 'despesa_fixa' OR tipo_de_conta = 'despesa_variavel') AND status_pagamento='pago' AND data_recebimento IS NOT NULL 
            GROUP BY mes_ano, tipo_de_conta ORDER BY mes_ano, tipo_de_conta;";
            $resultado = $conexao->executarQuery($sql);
            $dados = [];
            while ($row = mysqli_fetch_assoc($resultado)) {
            $dados[] = $row;
        }
        }catch (PDOException $e){
            echo "Erro ao consultar saldo: " . $e->getMessage();
        }
        return $dados;
    }
}