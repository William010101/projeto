<?php
include_once ('connection.php');

class Usuario
{
    public int $id_usuario;
    public string $nome;
    private string $senha;
    private string $email;

    // Construtor
    public function __construct(int $id_usuario, string $nome, string $senha, string $email)
    {
        $this->id_usuario = $id_usuario;
        $this->nome = $nome;
        $this->senha = $senha;
        $this->email = $email;
    }

    // Getter e Setter para id_usuario
    public function getIdUsuario(): int
    {
        return $this->id_usuario;
    }

    public function setIdUsuario(int $id_usuario): void
    {
        $this->id_usuario = $id_usuario;
    }

    // Getter e Setter para nome
    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    // Getter e Setter para senha
    public function getSenha(): string
    {
        return $this->senha;
    }

    public function setSenha(string $senha): void
    {
        $this->senha = $senha;
    }

    // Getter e Setter para email
    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public static function Logar($email, $senha)
    {
        $conexao = new Conexao();
        $sql = ("SELECT id_usuario, senha FROM usuario WHERE email='$email'");
        $result = $conexao->executarQuery($sql);
        if ($result->num_rows > 0) {
            // Verificar a senha
            $dados = $result->fetch_assoc();
            if (password_verify($senha, $dados['senha'])) {
                session_start();
                $_SESSION['id_usuario'] = $dados['id_usuario'];
                return true; // Logado com sucesso
            } else {
                return false; // Senha incorreta
            }
        }
        
    }
}

?>