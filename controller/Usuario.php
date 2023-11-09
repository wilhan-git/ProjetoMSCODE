<?php

    class Usuario
    {
        function __construct(
            private $email,
            private $senha
        ) {
        }

        public function email()
        {
            return $this->email;
        }

        public function senha()
        {
            return $this->senha;
        }

        public function setEmail($email)
        {
            $this->email = $email;
        }

        public function setSenha($senha)
        {
            $this->senha = $senha;
        }
}
