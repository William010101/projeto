<?php

include_once('connection.php');

class Cliente {
    // Atributos da classe Cliente
    private $id_cliente; // int
    private $nome; // string
    private $cpf_cnpj; // string
    private $cep; // int
    private $rua; // string
    private $numero_casa; // string
    private $bairro; // string
    private $cidade; // string
    private $estado; // string
    private $telefone; // int
    private $celular; // int
    private $email; // string
    private $banco; // int
    private $agencia; // int
    private $conta; // int
    private $tipo_conta; // string
    private $status_cliente; // string


    // Construtor da classe
    public function __construct($id_cliente, $nome, $cpf_cnpj, $cep, $rua, $numero_casa, $bairro, $cidade, $estado, $telefone, $celular, $email, $banco, $agencia, $conta, $tipo_conta, $status_cliente) {
        $this->id_cliente = (int) $id_cliente;
        $this->nome = (string) $nome;
        $this->cpf_cnpj = (string) $cpf_cnpj;
        $this->cep = (int) $cep;
        $this->rua = (string) $rua;
        $this->numero_casa = (string) $numero_casa;
        $this->bairro = (string) $bairro;
        $this->cidade = (string) $cidade;
        $this->estado = (string) $estado;
        $this->telefone = (int) $telefone;
        $this->celular = (int) $celular;
        $this->email = (string) $email;
        $this->banco = (int) $banco;
        $this->agencia = (int) $agencia;
        $this->conta = (int) $conta;
        $this->tipo_conta = (string) $tipo_conta;
        $this->status_cliente = (string) $status_cliente;
    
    }

    // Métodos para acessar os atributos (getters)
    public function getIdCliente(): int {
        return $this->id_cliente;
    }

    public function getNome(): string {
        return $this->nome;
    }

    public function getCpfCnpj(): string {
        return $this->cpf_cnpj;
    }

    public function getCep(): int {
        return $this->cep;
    }

    public function getRua(): string {
        return $this->rua;
    }

    public function getNumeroCasa(): string {
        return $this->numero_casa;
    }

    public function getBairro(): string {
        return $this->bairro;
    }

    public function getCidade(): string {
        return $this->cidade;
    }

    public function getEstado(): string {
        return $this->estado;
    }

    public function getTelefone(): int {
        return $this->telefone;
    }

    public function getCelular(): int {
        return $this->celular;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function getBanco(): string {
        return $this->banco;
    }

    public function getAgencia(): int {
        return $this->agencia;
    }

    public function getConta(): int {
        return $this->conta;
    }

    public function getTipoConta(): string {
        return $this->tipo_conta;
    }

    public function getStatusCliente(): string {
        return $this->status_cliente;
    }
    public function setIdCliente(int $id_cliente): void {
        $this->id_cliente = $id_cliente;
    }

    public function setNome(string $nome): void {
        $this->nome = $nome;
    }

    public function setCpfCnpj(string $cpf_cnpj): void {
        $this->cpf_cnpj = $cpf_cnpj;
    }

    public function setCep(int $cep): void {
        $this->cep = $cep;
    }

    public function setRua(string $rua): void {
        $this->rua = $rua;
    }

    public function setNumeroCasa(string $numero_casa): void {
        $this->numero_casa = $numero_casa;
    }

    public function setBairro(string $bairro): void {
        $this->bairro = $bairro;
    }

    public function setCidade(string $cidade): void {
        $this->cidade = $cidade;
    }

    public function setEstado(string $estado): void {
        $this->estado = $estado;
    }

    public function setTelefone(int $telefone): void {
        $this->telefone = $telefone;
    }

    public function setCelular(int $celular): void {
        $this->celular = $celular;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function setBanco(int $banco): void {
        $this->banco = $banco;
    }

    public function setAgencia(int $agencia): void {
        $this->agencia = $agencia;
    }

    public function setConta(int $conta): void {
        $this->conta = $conta;
    }

    public function setTipoConta(string $tipo_conta): void {
        $this->tipo_conta = $tipo_conta;
    }

    public function setStatusCliente(string $status_cliente): void {
        $this->status_cliente = $status_cliente;
    }
    public function Cadastro_Cliente(Cliente $cliente):string
    {
        try{
        $conexao = new Conexao();
        $sql="INSERT INTO cliente (nome, cpf_cnpj, cep, rua,numero_casa,bairro,cidade,estado,telefone, celular, email, banco, agencia, conta, tipo_conta, status_cliente) 
            VALUES ('$cliente->nome', '$cliente->cpf_cnpj', '$cliente->cep','$cliente->rua','$cliente->numero_casa','$cliente->bairro','$cliente->cidade','$cliente->estado', '$cliente->telefone' ,'$cliente->celular', '$cliente->email','$cliente->banco', '$cliente->agencia' , '$cliente->conta', '$cliente->tipo_conta','$cliente->status_cliente')";
         $conexao->executarQuery($sql);
         $conexao->fecharConexao();
         return "Cliente cadastrado com sucesso!";
        } catch (PDOException $e) {
            // Captura e trata o erro
            return "Erro ao cadastrar cliente: " . $e->getMessage();
        }
    }
    public static function Exibir_Clientes(): array {
        $clientes = []; // Array para armazenar os objetos Cliente

        try {
            $conexao = new Conexao();
            $sql = "SELECT * FROM cliente WHERE status_cliente = 'ativo'";
            $resultado = $conexao->executarQuery($sql);

            // Verifica se há resultados
            if ($resultado->num_rows > 0) {
                // Loop através dos resultados
                while ($row = $resultado->fetch_assoc()) {
                    // Criar objeto Cliente
                    $cliente = new Cliente(
                        $row['id_cliente'],
                        $row['nome'],
                        $row['cpf_cnpj'],
                        $row['cep'],
                        $row['rua'],
                        $row['numero_casa'],
                        $row['bairro'],
                        $row['cidade'],
                        $row['estado'],
                        $row['telefone'],
                        $row['celular'],
                        $row['email'],
                        $row['banco'],
                        $row['agencia'],
                        $row['conta'],
                        $row['tipo_conta'],
                        $row['status_cliente']
                    );

                    // Adicionar cliente ao array de clientes
                    $clientes[] = $cliente;
                }
            }

            $conexao->fecharConexao();
        } catch (Exception $e) {
            echo "Erro ao exibir clientes: " . $e->getMessage();
        }

        return $clientes;
    }

    public static function Apagar_Cliente($idcliente)
    {
        try{
            $conexao = new Conexao(); 
            date_default_timezone_set('America/Sao_Paulo');
            $datalocal = date('Y/m/d H:i:s');
            $sql= "UPDATE cliente SET status_cliente='inativo', exclusao_cliente='$datalocal' WHERE id_cliente='$idcliente'";
            $conexao->executarQuery($sql);
            $conexao->fecharConexao();
        }catch(Exception $e) {
            echo "Erro ao inativar cliente: " . $e->getMessage();
        }

    }

}


