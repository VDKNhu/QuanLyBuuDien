const list = document.querySelectorAll(".list");
console.log(list);
const KhacContent = document.querySelectorAll(".KhacContent");
console.log(KhacContent);
for(let i = 0; i < list.length; i++){
    list[i].addEventListener("click", function(){
        for(let j = 0; j < list.length; j++){
            list[j].classList.remove("backgd");
            KhacContent[j].classList.add("action");
        }
        list[i].classList.add("backgd");
        KhacContent[i].classList.remove("action");
    });
}