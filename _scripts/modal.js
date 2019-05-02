var modal = document.getElementById('myModal');
var modalImg = document.getElementById('img');
var captionText = document.getElementById('caption');

function showModal(capNr){
    var cap = $(".cap"+capNr)[0];
    modal.style.display = 'block';
    modalImg.src = cap.src;
    captionText.innerHTML = cap.alt;

    if($("body").css("overflow") == "auto"){
        $("body,html").css("overflow", "hidden");
    }else{
        $("body,html").css("overflow", "auto");
    }
}

var close = document.getElementById('hideModal');
close.onclick = function() {
    modal.style.display = 'none';

    if($("body").css("overflow") == "auto"){
        $("body,html").css("overflow", "hidden");
    }else{
        $("body,html").css("overflow", "auto");
    }
}

// modal.onclick = function(){
//     modal.style.display = 'none';

//     if($("body").css("overflow") == "auto"){
//         $("body,html").css("overflow", "hidden");
//     }else{
//         $("body,html").css("overflow", "auto");
//     }
// }