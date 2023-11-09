<?php
      require_once("/xampp/htdocs/ProjetoFinal/assets/config/Conexao.php");
      class ValidaLogin
      {
        public $idUser;
        public $username;
        public $sobrenome;
        public $cidade;
        public $estado;
        public $contato;
        public $genero;

        function __construct(
          private readonly Usuario $usuario
        ) {
        }

        function execute()
        {
          try {

            $query = Conexao::conectar()->prepare("SELECT * FROM tb_usuario WHERE Email = ?");
            $email = $this->usuario->email();
            $senha = $this->usuario->senha();
            $query->bindParam(1, $email);
            $query->execute();
            $verifica = $query->fetchAll();

            if($query->rowCount() > 0) {
                if (password_verify($senha, $verifica[0]["Senha"])) {
                  $this->idUser = $verifica[0]["ID_Usuario"];
                  $this->username = $verifica[0]["Nome"];
                  $this->sobrenome = $verifica[0]["Sobrenome"];
                  $this->cidade = $verifica[0]["Cidade"];
                  $this->estado = $verifica[0]["UF_Estado"];
                  $this->contato = $verifica[0]["Contato"];
                  $this->genero = $verifica[0]["Genero"];
                  return true;
                } else {
                  $msgErro = "SENHA INCORRETA, POR FAVOR INSIRA A SENHA CORRETA";

                  return $msgErro;
                }
              }
               $msgErro = "EMAIL INCORRETO, POR FAVOR INSIRA O EMAIL CORRET0";
            
               return $msgErro;
          } catch (PDOException $e) {
               echo "erro na consulta";
          }
        }
      }
