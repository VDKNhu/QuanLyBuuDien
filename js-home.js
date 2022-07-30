//chạy hình
const myImage = document.querySelector(".myImage");
window.onload = function(){
    setTimeout("switchImage()", 3000);
}
var current = 1;
var numberImg = 3;
function switchImage(){
    current ++;
    myImage.src = "image/lib" + current + ".jpg";
    if(current == numberImg){
        current = 0;
    }
    setTimeout("switchImage()", 3000);
}

