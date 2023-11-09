
const closeModalButton = document.querySelector("#close-modal");
const modal = document.querySelector("#modal");
const fade = document.querySelector("#fade");

function toggleModal(){
    modal.classList.toggle("hide");
    fade.classList.toggle("hide");
};

closeModalButton.addEventListener("click",toggleModal);


