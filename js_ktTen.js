function show_result(){
        // Lấy hai thẻ HTML
        var input = document.getElementById("message");
         var thongbao = document.getElementById("thongbao");
        // Gán nội dung ô input vào thẻ div
        let dau = input.value;
        let con = "0";
        let con1 = "1";
        let con2 = "2";
        let con3 = "3";
        let con4 = "4";
        let con5 = "5";
        let con6 = "6";
        let con7 = "7";
        let con8 = "8";
        let con9 = "9";

        if(dau.search(con) != -1 || dau.search(con1) != -1 || dau.search(con2) != -1 || dau.search(con3) != -1 
            || dau.search(con4) != -1 || dau.search(con5) != -1 || dau.search(con6) != -1|| dau.search(con7) != -1
            || dau.search(con8) != -1 || dau.search(con9) != -1){
            thongbao.innerHTML = "Không chứa số!";
        }
        else{
            thongbao.innerHTML = " ";
        }
}
function show_result1(){
    // Lấy hai thẻ HTML
    var input = document.getElementById("message1");
     var thongbao = document.getElementById("thongbao1");
    // Gán nội dung ô input vào thẻ div
    let dau = input.value;
    let con = "0";
    let con1 = "1";
    let con2 = "2";
    let con3 = "3";
    let con4 = "4";
    let con5 = "5";
    let con6 = "6";
    let con7 = "7";
    let con8 = "8";
    let con9 = "9";

    if(dau.search(con) != -1 || dau.search(con1) != -1 || dau.search(con2) != -1 || dau.search(con3) != -1 
        || dau.search(con4) != -1 || dau.search(con5) != -1 || dau.search(con6) != -1|| dau.search(con7) != -1
        || dau.search(con8) != -1 || dau.search(con9) != -1){
        thongbao.innerHTML = "Tên tài khoảng không chứa số!";
    }
    else{
        thongbao.innerHTML = " ";
    }
}