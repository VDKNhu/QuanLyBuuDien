const baocao = document.querySelector(".navbaocao");

const detail = document.querySelector(".detail");

baocao.addEventListener("click", function(){
    detail.classList.toggle("action");
})