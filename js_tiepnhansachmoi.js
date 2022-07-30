const inputM = document.querySelectorAll(".inputM");
const navM = document.querySelectorAll(".navM");
for(let i = 0; i < navM.length; i++){
    navM[i].addEventListener("click", function(){
        inputM[i].classList.remove("action");
        navM[i].classList.add("action");
    })
}
//them tac gia
const plusbtn = document.querySelectorAll(".plusbtn");
// console.log(plusbtn);
const navbar = document.querySelectorAll(".navbarTG");
// console.log(navbar);
for(let i = 0; i< plusbtn.length; i++){
    plusbtn[i].addEventListener("click", function(){
        navbar[i+1].classList.remove("action")

    })
}
//them tacgia moi
const  jsbtnM = document.querySelectorAll(".jsbtnM");
console.log(jsbtnM);
const navbarM = document.querySelectorAll(".navbarM");
console.log(navbarM);
for(let i =0; i < jsbtnM.length; i++){
    jsbtnM[i].addEventListener("click", function(){
        navbarM[i].classList.remove("action");
    })
}

