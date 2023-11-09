<?php
    session_start();
    require_once('/xampp/htdocs/ProjetoFinal/controller/Usuario.php');
    require_once('/xampp/htdocs/ProjetoFinal/model/ValidarLogin.php');

    //Iniciando Variaveis Vazias;
    $classeModal = "hide";
    $msgErro = " ";

    /*Validação login*/ 
    if (isset($_POST['acao'])) {
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        $usuario = new Usuario($email, $senha);
        $validarLogin = new ValidaLogin($usuario);
        $executaLogin = $validarLogin->execute();

        if ($executaLogin == 1) {
            $_SESSION['login'] = $email;
            $_SESSION['senha'] = $senha;
            $_SESSION['id_usuario'] = $validarLogin->idUser;
            $_SESSION['nome'] = $validarLogin->username;
            $_SESSION['sobrenome'] = $validarLogin->sobrenome;
            $_SESSION['cidade'] = $validarLogin->cidade;
            $_SESSION['estado'] = $validarLogin->estado;
            $_SESSION['contato'] = $validarLogin->contato;
            $_SESSION['genero'] = $validarLogin->genero;
            header("Location:http://localhost/ProjetoFinal/view/pgEcommerce.php");
        } else {
            unset($_SESSION['login']);
            unset($_SESSION['senha']);
            $classeModal = "";
            $msgErro = $executaLogin; 
        }
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../ProjetoFinal/assets/css/style.css">
    <title>Login</title>
</head>

<body>
    
    <main>
        <div class="formulario-login">
            <!-- Modal de erro -->
            <div id="fade" class="<?= $classeModal ?>"></div>
            <div id="modal" class="<?= $classeModal ?>">
                <div class="modal-header">
                    <h2>ERRO</h2>
                    <button class= "btn-modal" id="close-modal">Fechar</button>
                </div>
                <div class="modal-body">

                    <p> <?=$msgErro ?></p>

                </div>
            </div>
            <!-- Fim Modal de erro -->
            <div class="form-container">
            <div class="header-form">
                    <h1>LOGIN</h1>
                    <img class="Logo-login" src="../ProjetoFinal/assets/img/logo1.png" alt="">
                    
            </div>
                <form action="" method="POST">
                        <input type="email" id="Iemail" name="email" placeholder="Email" required>
        
                        <input type="password" id="Isenha" name="senha" placeholder="Password" required>
            
                    <div class="form-group-checkbox">
                        <input type="checkbox" name="termo" id="Itermo" required>
                        <label for="termo">Aceitar termos de Uso</label>

                    </div>
                    <div>
                        <input type="submit" name="acao" value="SIGN IN" id="log">
                    </div>
                    <div class="cadastro-login">
                        <label for="cadastro">Não possui cadastro ? <a href="../ProjetoFinal/view/Cadastro.php">clique aqui</a></label>
                    </div>

                </form>

            </div>


        </div>
    </main>
    <script src="../ProjetoFinal/assets/script/scriptLogin.js"></script>
</body>

</html>