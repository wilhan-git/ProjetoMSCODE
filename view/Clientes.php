<?php

session_start();
require_once('/xampp/htdocs/ProjetoFinal/assets/config/Conexao.php');
require_once('/xampp/htdocs/ProjetoFinal/assets/config/ConsultasSQL.php');
require_once('/xampp/htdocs/ProjetoFinal/controller/Produto.php');
require_once('/xampp/htdocs/ProjetoFinal/model/Carrinho.php');
$classeModal = "hide";
$msgErro = "";


if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)) {
    header('location:http://localhost/Projetoparalelo/index.php');
}

$padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);
//Editar dados//

if(isset($_POST['acao'])) {
    $nome = strip_tags($_POST['nome']);
    $sobrenome =strip_tags( $_POST['sobrenome']);
    $email = strip_tags($_POST['email']);
    $contato = strip_tags($_POST['contato']);
    $cidade = strip_tags($_POST['cidade']);
    $estado = strip_tags($_POST['estado']);
    $usuario = new ConsultasSql();
    
    $valida = $usuario->validaEmailEdit($email);

    if($valida === TRUE) {
        var_dump($valida);

        $resposta = $usuario->atualizaDados($_SESSION['id_usuario'],$nome,$sobrenome,$email,$contato,$cidade,$estado);

        if($resposta == true) {
            $classeModal = "hide";
            session_destroy();
            header("location:http://localhost/ProjetoFinal/");
        }
    }

    $msgErro = 'Email ja Existe, favor tentar outro!!!';

  
}
//Carrinho//

if (isset($_GET['id'])) {
    $id = strip_tags($_GET['id']);
    $lista = new ConsultasSql();
    $buscar_Produto = $lista->buscarProdutos($id);

    $id_User = $_SESSION['id_usuario'];
    $id_Produto = $buscar_Produto[0]['ID_Produto'];
    $Nome_Produto = $buscar_Produto[0]['Nome_Produto'];
    $descricao = $buscar_Produto[0]['Descricao'];
    $valor = $buscar_Produto[0]['Valor_Produto'];
    $img = $buscar_Produto[0]['Img_Produto'];


    $produto = new Produto($id_User, $id_Produto, $Nome_Produto, $descricao, $valor, $img);

    $carrinho = new Carrinho($produto);
    $carrinho->adicionarProduto();
}

/* Buscar os iten que estão adicionados no carrinho e produtos ja comprados pelo usuario*/
$lista = new ConsultasSql();
$status_carrinho = "Adicionado";
$status_historico = "Vendido";
$lista_carrinho = $lista->buscarCarrinho($_SESSION['id_usuario'], $status_carrinho);
$lista_historico = $lista->buscarCarrinho($_SESSION['id_usuario'], $status_historico);

if(isset($_GET['carrinho'])) {
    $id = strip_tags($_GET['carrinho']);
    $remove = new ConsultasSql();
    $remover_Produto = $remove->removerCarrinho($id);

    if ($remover_Produto === TRUE) {
        header('Location:http://localhost/ProjetoFinal/view/Clientes.php');
    }
}

/* finalizar compra com produtos do carrinho*/
if (isset($_GET['finalizarCompra'])) {
    $id = strip_tags($_GET['finalizarCompra']);
    $status = "Vendido";

    $finalizar = new ConsultasSql();

    $compra = $finalizar->finalizarCarrinho($status, $id);
}
/* Sair da Sessão*/

if (isset($_GET['sair'])) {
    session_destroy();
    die(header('Location:http://localhost/ProjetoFinal/'));
}

if (isset($_GET['editar'])) {
    if(isset($_GET['editar'])=='sim') {
    $classeModal = " ";
    }else{
        $classeModal = "hide";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styleCliente.css">
    <title>Perfil</title>
</head>

<body>
    <main>
        <div class="barra-navegacao">
            <div class="header-container">
                <a href="../view/PgEcommerce.php"><img class="logo" src="../assets/img/logo1.png" alt="Logo"></a>
            
                <nav class="nav-inks">
                    <ul>
                        <li id="btn-perfil-link" class="link">PERFIL</li>
                        <li   class="link"><button id="btn-cesta-link">CESTA</button></li>
                        <li id="btn-historico-link" class="link">HISTORICO</li>
                        <li class="link"><a href="?sair=sair">LOGOUT</a></li>
                        <li>
                            <div class="btn-close">
                                <img src="../assets/img/fechar.png" alt="fechar">
                            </div>
                        </li>
                    </ul>

                </nav>
                <div class="nav-icone">
                    <img class="menu-botao" src="../assets/img/botao-de-menu-de-tres-linhas-horizontais.png" alt="Menu Botão">


                </div>
            </div>

        </div>

        <div class="menu-lateral">
            <span> <a href=""><img src="../assets/img/user.png" alt="Perfil"><span class="nome-User"><?=$_SESSION["nome"]?></span></a></span>
            <br>
            <button id="btn-perfil-lateral" class="btn-perfil" href="">PERFIL</button>
            <br>
            <button id="btn-cesta-lateral" class="btn-perfil-2" href="">CESTA</button>
            <br>
            <button id="btn-historico-lateral" class="btn-perfil-3" href="">HISTÓRICO</button>

            <div class="menu-lateral-footer">
            <a href="?sair=sair"><img src="../assets/img/sair.png" alt="Botão Sair"></a>
            </div>
        </div>
         <!-- Modal de Editar -->
         <div id="fade" class="<?=$classeModal?>"></div>
        <div id="modal" class="<?=$classeModal?>">
            <div class="modal-header-editar">
                <h2>EDITAR</h2>
                <button class="btn-modal" id="close-modal">CANCELAR</button>
            </div>
            <p>
                <?=$msgErro?>
            </p>
            <div class="modal-body">
                <form id="form " class="form-modal" method="POST">
                    <div class="form-control">
                        <label for="nome">Nome</label>
                        <input type="text" id="iNome"  name="nome" required>
                    </div>
                    <div class="form-control">
                        <label for="sobrenome">Sobrenome</label>
                        <input type="text" id="iSobrenome" name="sobrenome" required>
                    </div>
                    <div class="form-control">
                        <label for="email">Email</label>
                        <input type="text" id="iEmail"  name="email" required>
                    </div>
                    <div class="form-control">
                        <label for="contato">Contato</label>
                        <input type="text" id="iContato"  name="contato" required>
                    </div>
                    <div class="form-control">
                        <label for="cidade">Cidade</label>
                        <input type="text" id="iCidade"  name="cidade" required>
                    </div>
                    <div class="form-control">
                        <label for="estado">Estado UF</label>
                        <input type="text" maxlength="2" id="iEstado"  name="estado" required>
                    </div>

                    <button type="submit" name="acao">SALVAR</button>
                </form>
            </div>
        </div>

        <!--Formulario de Redefinição -->
            <div id="redefinir-pg" class="form-cadastro">
                <form action="" method="POST">
                    <div class="form-header">
                        <div class="title-cadastro">
                            <h1>Dados Cadastrado</h1>
                        </div>
                    </div>
                    <div class="input-group">
                        <div class="input-box">
                            <label for="nome">Nome</label>
                            <input type="text" id="Inome" name="nome" value="<?=$_SESSION['nome']?>" required disabled>
                        </div>
                        <div class="input-box">
                            <label for="sobrenome">Sobrenome</label>
                            <input type="text" id="Isobrenome" name="sobrenome" value="<?=$_SESSION['sobrenome']?>" disabled>
                        </div>
                        <div class="input-box">
                            <label for="email">Email</label>
                            <input type="email" id="Iemail" name="email" value="<?=$_SESSION['login']?>" required disabled>
                        </div>

                        <div class="input-box">
                            <label for="cidade">Cidade</label>
                            <input type="text" id="Icidade" name="cidade" value="<?=$_SESSION['cidade']?>" disabled>
                        </div>

                        <div class="input-box">

                            <label for="estado">UF</label>
                            <input type="text" id="Iestado" name="estado" value="<?=$_SESSION['estado']?>" required disabled>
                        </div>

                        <div class="input-box">
                            <label for="contato">Contato</label>
                            <input type="tel" id="Icontato" name="contato" value="<?=$_SESSION['contato']?>" required disabled>
                        </div>

                        <div class="genero-inputs">
                            <div class="genero-titulo">
                                <h6>Gênero</h6>
                            </div>
                            <div class="genero-group">
                                <div class="genero-input">
                                    <p><?=$_SESSION['genero']?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="cadastrar-button">
                        <a  class="btn-editar" href="?editar=sim">REDEFINIR DADOS</a>
                    </div>
                </form>
            </div>
        <!-- Fim Formulario de Redefinição -->

        <!-- Tabela Compras adicionadas-->
        <div id="produtos-pg" class="tabela-produtos">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $valorTotal = 0; ?>
                    <?php foreach ($lista_carrinho as $produto_adicionado) : ?>
                        <tr>
                            <td>
                                <div class="produto-carrinho">
                                    <img src="..<?= $produto_adicionado['CarrinhoPcol'] ?>" alt="<?= $produto_adicionado['Nome_Produto'] ?>">

                                    <div class="infor">
                                        <div class="name_carrinho">
                                            <p><?= $produto_adicionado['Nome_Produto'] ?></p>
                                        </div>
                                        <div class="carrinho-descricao">
                                            <p><?= $produto_adicionado['Descricao_Produto'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><strong><?= numfmt_format_currency($padrao, $produto_adicionado['Valor_Produto'], "BRL") ?></strong></td>
                            <td>
                                <div class="qty">
                                    1
                                </div>
                            </td>
                            <td><a class="remove" href="?carrinho=<?= $produto_adicionado["ID_Carrinho"]?>"><img src="../assets/img/fechar.png" alt=""></a></td>
                        </tr>
                        <?php $valorTotal += $produto_adicionado['Valor_Produto']; ?>

                    <?php endforeach; ?>
                </tbody>

            </table>
            <div class="footer-tabela">
                <div class="finalizar_compra">
                    <div class="subtotal">
                        <span>Total</span><span><?= numfmt_format_currency($padrao, $valorTotal, "BRL") ?></span>
                    </div>
                    <a href="?finalizarCompra=<?= $_SESSION['id_usuario'] ?>">Finalizar Compra</a>
                </div>
            </div>

        </div>

        <!-- Tabela Historico de Compras -->
        <div id="historico-pg" class="tabela-historico">
            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Status</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($lista_historico as $produto_vendido) : ?>         
                            <tr>
                            <td>
                                <div class="produto-carrinho">
                                    <img src="..<?= $produto_vendido['CarrinhoPcol'] ?>" alt="<?= $produto_vendido['Nome_Produto'] ?>">

                                    <div class="infor">
                                        <div class="name_carrinho">
                                            <p><?= $produto_vendido['Nome_Produto'] ?></p>
                                        </div>
                                        <div class="carrinho-descricao">
                                            <p><?= $produto_vendido['Descricao_Produto'] ?></p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td><strong><?= numfmt_format_currency($padrao, $produto_vendido['Valor_Produto'], "BRL") ?></strong></td>
                            <td>
                                <div class="qty">
                                    1
                                </div>
                            </td>
                            <td>
                                <p><?= $produto_vendido['Status_Produto'] ?>
                            </td>
                            <td>
                                <p><?= $produto_vendido['Data_Produto'] ?>
                            </td>
                    </tr>

                    <?php endforeach; ?>
                </tbody>

            </table>

        </div>



    </main>
    <script src="../assets/script/scriptCliente.js"></script>
    <script>
        const navbar = document.querySelector(".barra-navegacao");
        const menubotao = document.querySelector(".menu-botao");
        const botaoclose = document.querySelector(".btn-close");


        menubotao.addEventListener("click", () => {
            navbar.classList.toggle("show-menu");
            menubotao.classList.toggle("close-menu");

        })
        botaoclose.addEventListener("click", () => {
            navbar.classList.toggle("show-menu");
            menubotao.classList.toggle("close-menu");
        })

        const botaoPerfil = document.getElementById("btn-perfil-lateral");
        const botaoCesta = document.getElementById("btn-cesta-lateral");
        const botaoHistorico = document.getElementById("btn-historico-lateral");
        let pgHistorico = document.getElementById("historico-pg");
        let pgProdutos = document.getElementById("produtos-pg");
        let pgRedefinir = document.getElementById("redefinir-pg");
     
        botaoPerfil.addEventListener("click",()=>{
            pgHistorico.style.display="none";
            pgProdutos.style.display="none";
            pgRedefinir.style.display="flex";
        });
        botaoCesta.addEventListener("click",()=>{
            pgHistorico.style.display="none";
            pgRedefinir.style.display="none";
            pgProdutos.style.display="flex";
           
        });
        botaoHistorico.addEventListener("click",()=>{
            pgProdutos.style.display="none";
            pgRedefinir.style.display="none";
            pgHistorico.style.display="flex";
            
        });



    </script>
</body>

</html>