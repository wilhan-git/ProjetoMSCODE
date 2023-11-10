<?php 
    require_once("/xampp/htdocs/ProjetoFinal/controller/Produto.php");
    require_once("/xampp/htdocs/ProjetoFinal/assets/config/Conexao.php");

    Class Carrinho{
        private $data;
        public function __construct(
            private readonly Produto $produto
        ){
            $this->data = date("Y-m-d");
        }

            public function adicionarProduto(){
                try{
                        $query = Conexao::conectar()->prepare("INSERT INTO carrinhop (ID_User,ID_Produto,Nome_Produto,Descricao_Produto,Valor_Produto,CarrinhoPcol,Quantidade,Status_Produto,Data_Produto)
                        VALUES (?,?,?,?,?,?,?,?,?)");
                        $idUser = $this->produto->idUser();
                        $idProduto = $this->produto->idProduto();
                        $nomeProduto = $this->produto->nomeProduto();
                        $descricaoProduto = $this->produto->descricaoProduto();
                        $valorProduto = $this->produto->valorProduto();
                        $img_Produto = $this->produto->imgProduto();
                        $quantidade = 1;
                        $status = "Adicionado";
                        $data = $this->data;
                        
                        $query->bindParam(1,$idUser);
                        $query->bindParam(2,$idProduto);
                        $query->bindParam(3,$nomeProduto);
                        $query->bindParam(4,$descricaoProduto);
                        $query->bindParam(5,$valorProduto);
                        $query->bindParam(6, $img_Produto);
                        $query->bindParam(7, $quantidade);
                        $query->bindParam(8, $status);
                        $query->bindParam(9, $data);

                        $query->execute();

                        return TRUE;
                    } catch (PDOException $e) {
                        echo "erro na consulta";
                }

            }
            
    }
?>