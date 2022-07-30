document.querySelector(".btnsuatheloai").addEventListener("click", function(){
    document.querySelector(".divsuatheloai").classList.remove("action");
});
document.querySelector(".btnxoatheloai").addEventListener("click", function(){
    document.querySelector(".divxoatheloai").classList.remove("action");
});
document.querySelector(".btnsuatacgia").addEventListener("click", function(){
    document.querySelector(".divsuatacgia").classList.remove("action");
});
document.querySelector(".btnxoatacgia").addEventListener("click", function(){
    document.querySelector(".divxoatacgia").classList.remove("action");
});
const dong = document.querySelectorAll(".close");
for(let i = 0; i < dong.length; i++){
    dong[i].addEventListener("click", function(){
    document.querySelector(".divsuatheloai").classList.add("action");
    document.querySelector(".divxoatheloai").classList.add("action");
    document.querySelector(".divsuatacgia").classList.add("action");
    document.querySelector(".divxoatacgia").classList.add("action");
    })
}