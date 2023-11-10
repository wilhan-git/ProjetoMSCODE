<?php 

Class Limpeza{
    public function limpeza_string($dado){
        $dado = trim($dado);
        $dado = htmlspecialchars($dado);
        $padrãoString = "/^[a-zA-Z-' ]*$/";

        if(!preg_match($padrãoString,$dado)){
            return false;

        }else{
            $dado = ucfirst(strtolower($dado));
            return $dado;
        }
    }

    public function limpeza_telefone($dado){
        $dado = trim($dado);
        $dado = htmlspecialchars($dado);
        $padrãoTel="/^[0-9]{11}$/";

        if(!preg_match($padrãoTel,$dado)){
            return false;
        }else{
            return $dado;
        }
    }

}

?>