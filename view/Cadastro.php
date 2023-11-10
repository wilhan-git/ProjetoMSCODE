<?php
    require_once('/xampp/htdocs/ProjetoFinal/model/CadastroUser.php');
    require_once('../assets/config/limpeza.php');
    $msgErro = "";
    $classeModal = "hide";

    if (isset($_POST['cadastro'])) {
        $limpeza = new Limpeza();
        $nome = $limpeza->limpeza_string($_POST['nome']);
        $sobrenome =$limpeza->limpeza_string($_POST['sobrenome']);
        $email = $_POST['email'];
        $senha = password_hash($_POST['senha'], PASSWORD_DEFAULT);
        $repitaSenha = $_POST['repitaSenha'];
        $cidade = $_POST['cidade'];
        $estado = $_POST['estado'];
        $cpf = $_POST['cpf'];
        $contato = $limpeza->limpeza_telefone($_POST['contato']);
        $genero = $_POST['genero'];
        $cadastrar = new CadastroUser($nome, $sobrenome, $cidade, $estado, $cpf, $contato, $genero, $email, $senha);

        if($nome === false || $sobrenome === false) {
            $msgErro = 'Somente letras e espaços no campo Nome e Sobrenome';
            $classeModal = '';
        }elseif($contato===false) {
            $msgErro = 'No campo Contatos só e permitido Numeros, Favor adicionar DDD';
            $classeModal = '';
        }elseif ($cadastrar->validaEmail($email) == TRUE) {
                if(password_verify($repitaSenha, $senha)) {
                    $cadastrar->cadastrarUser();
                    die(header("Location:http://localhost/ProjetoFinal/index.php"));
                }else{
                    $msgErro = "Senha Não Compativel";
                    $classeModal = " ";

                } 
                
        }else{
            $classeModal = " ";
            $msgErro = "Email já Cadastrado";
        }
       
    }

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styleCadastro.css">
    <title>Cadastro</title>
</head>

<body>

    <div class="container-cadastro">
        <!-- Modal de erro -->
        <div id="fade" class="<?=$classeModal ?>"></div>
        <div id="modal" class="<?=$classeModal ?>">
            <div class="modal-header">
                <h2>ERRO</h2>
                <button class="btn-modal" id="close-modal">Fechar</button>
            </div>
            <div class="modal-body">

                <p> <?= $msgErro ?></p>

            </div>
        </div>
        <!-- Fim Modal de erro -->
        <div class="form-image">
            <img src="../assets/img/Sign up-rafiki.svg">
        </div>
        
        <div class="form-cadastro">
            <form action="" method="POST">
                <div class="form-header">
                    <div class="title-cadastro">
                        <h1>Cadastre-Se</h1>
                    </div>
                    <div class="login-button">
                        <button><a href="../index.php">Entrar</a></button>
                    </div>
                </div>
                <div class="input-group">
                    <div class="input-box">
                        <label for="nome">Nome</label>
                        <input type="text" id="Inome" name="nome" required>
                    </div>
                    <div class="input-box">
                        <label for="sobrenome">Sobrenome</label>
                        <input type="text" id="Isobrenome" name="sobrenome" required>
                    </div>
                    <div class="input-box">
                        <label for="email">Email</label>
                        <input type="email" id="Iemail" name="email" required>
                    </div>
                    <div class="input-box">
                        <label for="senha">Senha</label>
                        <input type="password" name="senha" id="Isenha" required>
                    </div>
                    <div class="input-box">
                        <label for="repitaSenha">Repita sua Senha</label>
                        <input type="password" name="repitaSenha" id="IrepitaSenha" required>
                    </div>
                    <div class="input-box">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="Icidade" name="cidade" required>
                    </div>

                    <div class="input-box">

                        <label for="estado">UF</label>
                        <input type="text" id="Iestado" name="estado" required>
                    </div>

                    <div class="input-box">
                        <label for="cpf">CPF</label>
                        <input type="text" id="Icpf" name="cpf" required>
                    </div>

                    <div class="input-box">
                        <label for="contato">Contato</label>
                        <input type="tel" id="Icontato" name="contato" placeholder="(xx) xxxxx-xxxx" required>
                    </div>

                    <div class="genero-inputs">
                        <div class="genero-titulo">
                            <h6>Gênero</h6>
                        </div>
                        <div class="genero-group">
                            <div class="genero-input">
                                <input type="radio" name="genero" id="Igenero" value="Masculino" required>
                                <label for="genero">Masculino</label>

                            </div>
                            <div class="genero-input">
                                <input type="radio" name="genero" id="Igenero" value="Feminino" required>
                                <label for="genero">Feminino</label>

                            </div>
                            <div class="genero-input">
                                <input type="radio" name="genero" id="Igenero" value="Não Declarado" required>
                                <label for="genero">Não Declarar</label>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="cadastrar-button">
                    <input type="submit" name="cadastro" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
    <script src="../assets/script/scriptLogin.js"></script>
</body>

</html>