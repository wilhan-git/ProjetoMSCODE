<?php 
    require_once("/xampp/htdocs/ProjetoFinal/assets/config/Conexao.php");

    Class ConsultasSql{
        private $id_user;
        private $nome;

        public function carregarProdutos($classificacao){
            $query = Conexao::conectar()->prepare("SELECT * FROM produto WHERE Categoria_Produto = ?");
            $query->bindParam(1, $classificacao);
            $query->execute();
            $lista_dados = $query->fetchAll();
            return $lista_dados;
        }

        public function buscarProdutos($id_produto){
            $query = Conexao::conectar()->prepare("SELECT * FROM produto WHERE ID_Produto = ?");
            $query->bindParam(1,$id_produto);
            $query->execute();
            $lista_produto = $query->fetchAll();
            
            return $lista_produto;

        }

        public function buscarCarrinho($id_User,$status_Produto){
            $query = Conexao::conectar()->prepare("SELECT * FROM carrinhop WHERE ID_User = ? AND Status_Produto = ?  ORDER BY Data_Produto DESC ");
            $query->bindParam(1,$id_User);
            $query->bindParam(2,$status_Produto);
            $query->execute();
            $carrinho = $query->fetchAll();
            
            return $carrinho;
        }

        public function removerCarrinho($id_carrinho){
            $status_Produto = "Adicionado";
            $query = Conexao::conectar()->prepare("DELETE FROM carrinhop WHERE ID_Carrinho = ? AND Status_Produto = ?");
            $query->bindParam(1,$id_carrinho);
            $query->bindParam(2,$status_Produto);
            $query->execute();

            return TRUE;

        }

        public function finalizarCarrinho($status_finalizar,$id_user){
            $status = "Adicionado";
            $query = Conexao::conectar()->prepare("UPDATE carrinhop SET Status_Produto = ? WHERE ID_User = ? AND Status_Produto = ?");
            $query->bindParam(1,$status_finalizar);
            $query->bindParam(2,$id_user);
            $query->bindParam(3,$status);
            $query->execute();

            return TRUE;

        }

        public function atualizaDados($id,$nome,$snome,$email,$cont,$cidade,$uf){
            try{
                $query = Conexao::conectar()->prepare("UPDATE tb_usuario SET Nome = ?, Sobrenome = ?, Email = ?, Contato = ?, Cidade = ?,UF_Estado = ?
                WHERE ID_Usuario = ?");
                $query->bindParam(1,$nome);
                $query->bindParam(2,$snome);
                $query->bindParam(3,$email);
                $query->bindParam(4,$cont);
                $query->bindParam(5,$cidade);
                $query->bindParam(6, $uf);
                $query->bindParam(7,$id);
    
                $query->execute();
                return TRUE;
            } catch(PDOException $e){
                
                return "Erro Na Consulta" . $e;
        }
    }
    
    function validaEmailEdit($email){
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