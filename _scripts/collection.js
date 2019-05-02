$(".show_sort").click(function(){
    if($(".sort_arrow").css("transform") == "none"){
        $(".sort_arrow").css("transform", "rotate(180deg)");
    }else{
        $(".sort_arrow").css("transform", "none");
    }

    if($(".hidden_sort_div").css("display") == "none"){
        $(".hidden_sort_div").css("display", "block");
    }else{
        $(".hidden_sort_div").css("display", "none");
    }
});

$(".sort_by").change(function(){
    selected = $(".sort_by").val();
    
    if(selected != 'id'){
        $(".radio1").html('Rosnąco (A-Z)');
        $(".radio2").html('Malejąco (Z-A)');
    }else{
        $(".radio1").html('Najstarsze');
        $(".radio2").html('Najnowsze');
    }
});

window.onload = function(){
    selected = $(".sort_by").val();
    
    if(selected != 'id'){
        $(".radio1").html('Rosnąco (A-Z)');
        $(".radio2").html('Malejąco (Z-A)');
    }else{
        $(".radio1").html('Najstarsze');
        $(".radio2").html('Najnowsze');
    }
}