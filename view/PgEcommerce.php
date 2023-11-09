<?php
session_start();
require_once('/xampp/htdocs/ProjetoFinal/assets/config/Conexao.php');
require_once('/xampp/htdocs/ProjetoFinal/assets/config/ConsultasSQL.php');
require_once('/xampp/htdocs/ProjetoFinal/controller/Produto.php');
require_once('/xampp/htdocs/ProjetoFinal/model/Carrinho.php');
$qtCarrinho = 0;

if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)) {
    header('location:http://localhost/ProjetoFinal/');
}

$lista = new ConsultasSql();
$telefone = "Telefone";
$phone = "Phones";
$notebook = "Notebook";
$lista_Phones = $lista->carregarProdutos($phone);
$lista_Notebook = $lista->carregarProdutos($notebook);
$lista_Telefone = $lista->carregarProdutos($telefone);

$padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);


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

$status_carrinho = "Adicionado";
$lista_carrinho = $lista->buscarCarrinho($_SESSION['id_usuario'], $status_carrinho);

$qtCarrinho = count($lista_carrinho);
if (isset($_GET['carrinho'])) {
    $id = strip_tags($_GET['carrinho']);
    $remove = new ConsultasSql();
    $remover_Produto = $remove->removerCarrinho($id);

    if ($remover_Produto === TRUE) {
        header('Location:http://localhost/ProjetoFinal/view/pgEcommerce.php');
    }
}


if (isset($_GET['finalizarCompra'])) {
    $id = strip_tags($_GET['finalizarCompra']);
    $status = "Vendido";

    $finalizar = new ConsultasSql();

    $compra = $finalizar->finalizarCarrinho($status, $id);
}

if (isset($_GET['sair'])) {
    session_destroy();
    die(header('Location:http://localhost/ProjetoFinal/'));
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/styleStore.css">
    <title>WH Store</title>
</head>

<body>
    <div class="barra-navegacao">
        <div class="header-container">
            <img class="logo" src="../assets/img/logo1.png" width="200px" height="200px">
            <div class="bem-vindo"> Olá, <br> <strong><span><?= $_SESSION["nome"] ?><br></span></strong> Seja Bem Vindo</div>
            <nav class="nav-inks">
                <ul>
                    <li id="open-cart-link" class="link">Carrinho</li>
                    <li class="link">Perfil</li>
                    <li class="link"><a href="?sair=sair">Logout</a></li>
                    <li>
                        <div class="btn-close">
                            <img src="../access/img/fechar.png" alt="fechar">
                        </div>
                    </li>
                </ul>

            </nav>
            <div class="nav-icone">
                <span><img id="open_cart_btn" class="btn-carrinho-compras" src="../assets/img/carrinho.png" alt="Carrinho"><span id="carrinho"><?=$qtCarrinho?></span></span>
                <span> <a href="../view/Clientes.php"><img src="../assets/img/user.png" alt="Perfil"></a></span>
                <span> <a href="?sair=sair"><img src="../assets/img/sair.png" alt="Perfil"></a></span>
            </div>

            <div class="menu">
                <img class="menu-botao" src="../assets/img/botao-de-menu-de-tres-linhas-horizontais.png" alt="Menu Botão">
            </div>
        </div>

    </div>

    <header>
        <div class="header-container">
            <div class="header-banner">
                <img class="img-banner" src="../assets/img/banner.jpg" alt="banner">
            </div>

            <div class="backdrop"></div>
            <div id="sidecart" class="sidecart">
                <div class="cart_content">
                    <div class="cart_header">
                        <img src="/accsess/img/carrinho.png" alt="">
                        <div class="header_title">
                            <h2>Carrinho</h2>
                        </div>
                        <span id="close_btn" class="close_btn">X</span>
                    </div>
                    <div class="cart_items">
                        <?php $valorTotal = 0; ?>
                        <?php foreach ($lista_carrinho as $carinho_Produto) : ?>
                            <div class="cart_item">
                                <div class="remove_item">
                                    <a href="?carrinho=<?= $carinho_Produto["ID_Carrinho"] ?>"><span>&times;</span></a>
                                </div>
                                <div class="item_img">
                                    <img src="..<?= $carinho_Produto['CarrinhoPcol'] ?>" alt="<?= $carinho_Produto['Nome_Produto'] ?>">
                                </div>
                                <div class="item_details">
                                    <p><?= $carinho_Produto['Descricao_Produto'] ?></p>
                                    <strong><?= numfmt_format_currency($padrao, $carinho_Produto['Valor_Produto'], "BRL") ?></strong>
                                </div>
                            </div>
                            <?php
                            $valorTotal += $carinho_Produto['Valor_Produto'];
                            $qtCarrinho += 1;
                            ?>

                        <?php endforeach; ?>

                    </div>
                    <div class="cart_actions">
                        <div class="subtotal">
                            <p>SUBTOTAL</p>
                            <p><span id="subtotal_price"><?= numfmt_format_currency($padrao, $valorTotal, "BRL") ?></span></p>
                        </div>
                        <a class="btn-compra" href="?finalizarCompra=<?= $_SESSION['id_usuario'] ?>">Finalizar Compra</a>
                    </div>
                </div>
            </div>
        </div>


    </header>

    <main>
        <div class="gray-background">


            <img src="../assets/img/heartset_amarelo.png" alt="banner headset" width="100%" height="300px">

        </div>

        <!--  -->
        <div>
            <div class="page-inner-content">
                <h3 class="section-title">Phones</h3>
                <div class="subtitle-underline"></div>

                <div class="cols cols-4">

                    <?php foreach ($lista_Phones as $lista) : ?>

                        <div class="produtos">
                            <div class="produto">
                                <div class="top">
                                    <img class="icone" src="../assets/img/carrinho_laranja.png" alt="">
                                </div>
                                <img class="imagems" src="..<?= $lista['Img_Produto'] ?>" alt="<?= $lista['Nome_Produto'] ?>">
                                <p class="ptxt"><?= $lista['Nome_Produto'] ?></p>
                                <p class="ptxt"><?= $lista['Descricao'] ?></p>
                                <p class="rate">&#9733;&#9733;&#9733;&#9733;&#9734;</p>
                                <div class="valores">
                                    <p><?= numfmt_format_currency($padrao, $lista['Valor_Produto'], "BRL") ?></p>
                                    <p>Disponivel <span><?= $lista['Quantidade_Est'] ?></span> Unidades</p>
                                </div>
                                <a class="botao" href="?id=<?= $lista["ID_Produto"] ?>"><span>Comprar</span></a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>

            </div>
        </div>
        </div>
        <!--  -->
        <div class="gray-background">
            <img src="../assets/img/computador_preto.png" alt="banner computador" width="100%"  height="300px">
        </div>

        <!--  -->

        <div>
            <div class="page-inner-content">
                <h3 class="section-title">Notebooks</h3>
                <div class="subtitle-underline"></div>
                <div class="cols cols-4">

                    <?php foreach ($lista_Notebook as $lista) : ?>

                        <div class="produtos">
                            <div class="produto">
                                <div class="top">
                                    <img class="icone" src="../assets/img/carrinho_laranja.png" alt="">
                                </div>
                                <img class="imagems" src="..<?= $lista['Img_Produto'] ?>" alt="<?= $lista['Nome_Produto'] ?>">
                                <p class="ptxt"><?= $lista['Nome_Produto'] ?></p>
                                <p class="ptxt"><?= $lista['Descricao'] ?></p>
                                <p class="rate">&#9733;&#9733;&#9733;&#9733;&#9734;</p>
                                <div class="valores">
                                    <p><?= numfmt_format_currency($padrao, $lista['Valor_Produto'], "BRL") ?></p>
                                    <p>Disponivel <span><?= $lista['Quantidade_Est'] ?></span> Unidades</p>
                                </div>
                                <a class="botao" href="?id=<?= $lista["ID_Produto"] ?>"><span>Comprar</span></a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!--  -->
        <div class="gray-background">
            <img class="banner" src="../assets/img/celulares_amarelo.png" alt="banner celulares" width="100%"  height="300px">
        </div>

        <!--  -->

        <div>
            <div class="page-inner-content">
                <h3 class="section-title">Celulares</h3>
                <div class="subtitle-underline"></div>
                <div class="cols cols-4">

                    <?php foreach ($lista_Telefone as $lista) : ?>

                        <div class="produtos">
                            <div class="produto">
                                <div class="top">
                                    <img class="icone" src="../assets/img/carrinho_laranja.png" alt="">
                                </div>
                                <img class="imagems" src="..<?= $lista['Img_Produto'] ?>" alt="<?= $lista['Nome_Produto'] ?>">
                                <p class="ptxt"><?= $lista['Nome_Produto'] ?></p>
                                <p class="ptxt"><?= $lista['Descricao'] ?></p>
                                <p class="rate">&#9733;&#9733;&#9733;&#9733;&#9734;</p>
                                <div class="valores">
                                    <p><?= numfmt_format_currency($padrao, $lista['Valor_Produto'], "BRL") ?></p>
                                    <p>Disponivel <span><?= $lista['Quantidade_Est'] ?></span> Unidades</p>
                                </div>
                                <a class="botao" href="?id=<?= $lista["ID_Produto"] ?>"><span>Comprar</span></a>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </main>
</body>

<script src="../assets/script/scriptStore.js"></script>

</html>