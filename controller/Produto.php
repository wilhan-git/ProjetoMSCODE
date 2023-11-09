<?php 
    Class Produto{
        public function __construct(
            private $id_user,
            private $id_produto,
            private $nome_produto,
            private $descricao_produto,
            private $valor_produto,
            private $img_Produto
        ){

        }

        public function idUser(){
            return $this->id_user;
        }
        public function idProduto(){
            return $this->id_produto;
        }
        public function nomeProduto(){
            return $this->nome_produto;
        }
        public function descricaoProduto(){
            return $this->descricao_produto;
        }
        public function valorProduto(){
            return $this->valor_produto;
        }
        public function imgProduto(){
            return $this->img_Produto;
        }

    }


?>