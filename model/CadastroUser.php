<?php
    require_once("/xampp/htdocs/ProjetoFinal/assets/config/Conexao.php");


    class CadastroUser
    {

        function __construct(
            private $nome,
            private $sobrenome,
            private $cidade,
            private $estado,
            private $cpf,
            private $contato,
            private $genero,
            private $email,
            private $senha
        ) {
        }


        function cadastrarUser()
        {
            try {
                $query = Conexao::conectar()->prepare("INSERT INTO tb_usuario(Nome,Sobrenome,Email,Senha,Cpf,Contato,Genero,Cidade,UF_Estado) VALUES (?,?,?,?,?,?,?,?,?)");

                $query->bindParam(1,$this->nome);
                $query->bindParam(2,$this->sobrenome); 
                $query->bindParam(3,$this->email);  
                $query->bindParam(4,$this->senha);
                $query->bindParam(5,$this->cpf); 
                $query->bindParam(6, $this->contato); 
                $query->bindParam(7, $this->genero); 
                $query->bindParam(8,$this->cidade); 
                $query->bindParam(9,$this->estado); 
                $resultado = $query->execute();
        
                return $resultado;
            } catch (PDOException $e) {
                echo "erro na consulta";
            }
        }


        function validaEmail($email){
            $query = Conexao::conectar()->prepare("SELECT * FROM tb_usuario WHERE Email = ?");
            $query ->bindParam(1,$email);
            $query->execute();
           if($query->rowCount()<=0){
            return true;
           }else{
            return false;
           }

            

        }
    }
?>