<?php

class pessoa
{

    private $pdo;

    public function __construct($dbname, $host, $port, $usuario, $senha)
    {

        try {
            $this->pdo = new PDO("mysql:dbname=" . $dbname . ";host=" . $host . ";port=" . $port, $usuario, $senha);
        } catch (PDOException $e) {
            echo "Erro com banco de dados" . $e->getMessage();
            exit();
        } catch (Exception $e) {
            echo "Erro genérico" . $e->getMessage();;
            exit();
        }
    }

    public function buscarDados()
    {

        $lista = array();
        $consulta = $this->pdo->query("SELECT * FROM tb_pessoa ORDER BY ds_nome");
        $lista = $consulta->fetchAll(PDO::FETCH_ASSOC);
        return $lista;
    }

    public function cadastrarPessoa($nome, $sexo, $nasc, $telefone, $email)
    {
        $cmd = $this->pdo->prepare("SELECT id_pessoa FROM tb_pessoa WHERE ds_email = :e");
        $cmd->bindValue(":e", $email);
        $cmd->execute();

        if ($cmd->rowCount() > 0) {
            return false;
        } else {
            $cmd = $this->pdo->prepare("INSERT INTO tb_pessoa(ds_nome, cd_sexo, dt_nasc, nr_telefone, ds_email) 
            VALUES (:n, :s, :d, :t, :e) ");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":s", $sexo);
            $cmd->bindValue(":d", $nasc);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->execute();
            return true;
        }
    }

    public function excluirPessoa($id)
    {
        $cmd = $this->pdo->prepare("DELETE FROM tb_pessoa WHERE id_pessoa = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
    }

    public function buscarDadosPessoa($id)
    {
        $otro = array();
        $cmd = $this->pdo->prepare("SELECT * FROM tb_pessoa WHERE id_pessoa = :id");
        $cmd->bindValue(":id", $id);
        $cmd->execute();
        $otro = $cmd->fetch(PDO::FETCH_ASSOC);
        return $otro;
    }

    public function atualizarDados($id, $nome, $sexo, $nasc, $telefone, $email)
    {

    
            $cmd = $this->pdo->prepare("UPDATE tb_pessoa SET ds_nome = :n, cd_sexo = :s, dt_nasc = :d, nr_telefone = :t, ds_email = :e 
    WHERE id_pessoa = :id");
            $cmd->bindValue(":n", $nome);
            $cmd->bindValue(":s", $sexo);
            $cmd->bindValue(":d", $nasc);
            $cmd->bindValue(":t", $telefone);
            $cmd->bindValue(":e", $email);
            $cmd->bindValue("id", $id);
            $cmd->execute();
        
    }
}
