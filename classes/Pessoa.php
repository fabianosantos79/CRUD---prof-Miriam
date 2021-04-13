<?php
    require_once 'Conexao.php';

    class Pessoa{
        private $pdo;
    
        //CONSTRUTOR E CONEXÃO
        public function __construct(PDO $drive){
            $this->pdo = $drive;
        }
        
        //BUSCAR OS DADOS E COLOCAR NA TABELA
        public function buscarDados(){
            $sql = $this->pdo->query("SELECT * FROM pessoa ORDER BY nome");
            $sql->execute();

            $res = [];

            if($sql->rowCount() > 0){
                $res = $sql->fetchAll(PDO::FETCH_ASSOC);
                return $res;
            }
        }

        //CADASTRAR PESSOA NO BANCO DE DADOS
        public function cadastrarPessoa($nome, $telefone, $email){
            $sql = $this->pdo->prepare("SELECT id FROM pessoa WHERE email = :e");
            $sql->bindValue(':e', $email);
            $sql->execute();

            if($sql->rowCount() > 0){
                return false;
            }
            else{
                $sql = $this->pdo->prepare("INSERT INTO pessoa (nome, telefone, email) VALUES (:n, :t, :e)");
                $sql->bindValue(':n', $nome);
                $sql->bindValue(':t', $telefone);
                $sql->bindValue(':e', $email);
                $sql->execute();

                return true;
            }
        }

        //EXCLUIR PESSOA
        public function excluirPessoa($id){
            $sql = $this->pdo->prepare("DELETE FROM pessoa WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();

        }


        //BUSCAR PESSOA
        public function buscarPessoa($id){
            $res = [];
            $sql = $this->pdo->prepare("SELECT * FROM pessoa WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->execute();
            $res = $sql->fetch(PDO::FETCH_ASSOC);
            return $res;
        } 


        //ATUALIZAR DADOS
        public function atualizarDados($id, $nome, $telefone, $email){
            $sql = $this->pdo->prepare("UPDATE pessoa SET (nome, telefone, email) VALUES (:n, :t, :e) WHERE id = :id");
            $sql->bindValue(':id', $id);
            $sql->bindValue(':n', $nome);
            $sql->bindValue(':t', $telefone);
            $sql->bindValue(':e', $email);
            $sql->execute();
        }
    }
?>