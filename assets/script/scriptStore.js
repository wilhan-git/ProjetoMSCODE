const navbar = document.querySelector(".barra-navegacao");
const menubotao = document.querySelector(".menu-botao");
const botaoclose = document.querySelector(".btn-close");
const openBtn = document.getElementById("open_cart_btn");
const openBtnLink = document.getElementById("open-cart-link");
const cart = document.getElementById("sidecart");
const closeBtn = document.getElementById("close_btn");
const backdrop = document.querySelector(".backdrop");

menubotao.addEventListener("click", () => {
    navbar.classList.toggle("show-menu");
    menubotao.classList.toggle("close-menu");

})

botaoclose.addEventListener("click", () => {
    navbar.classList.toggle("show-menu");
    menubotao.classList.toggle("close-menu");
})


openBtn.addEventListener('click',openCart);
openBtnLink.addEventListener('click',openCart);
closeBtn.addEventListener('click',closeCart);

function openCart(){
    cart.classList.add('open');
    backdrop.style.display = 'block';

    setTimeout(()=>{
        backdrop.classList.add('show')
    },0)
    
}

function closeCart(){
    cart.classList.remove('open');
    backdrop.classList.remove('show');

    setTimeout(()=>{
        backdrop.style.display = 'none';
    },500)
}