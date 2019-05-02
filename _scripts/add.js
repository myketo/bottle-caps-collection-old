$("#add_image").change(function() {
    filename = this.files[0].name;
    $(".over_file").html(filename);

    readURL(this);

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.image').attr('src', e.target.result);
            };

            reader.readAsDataURL(input.files[0]);
        }
    }
});

window.onload = function(){
    info = ['brand', 'caption', 'color', 'country'];
    $default = ['Marka', 'Napis', 'Kolor', 'Kraj'];

    for(let i=0; i<info.length; i++){
        content = $("."+info[i]).text();
        
        if(content != $default[$i]){
            $("#add_"+info[i]).val(content);
        }
    }
}

$("#add_unknown").click(function(){
    if($(".unknown").css("display") == "none"){
        $(".unknown").css("display", "block");
    }else{
        $(".unknown").css("display", "none");
    }
});


$(".over_file").keypress(function(e) {
    if(e.key === " " || e.key === "Spacebar" || e.key==="Enter"){
        e.preventDefault();
        $("#add_image").click();
    }
});


$("input").keyup(function(){
    name = $(this).attr('name');
    value = $(this).val();
    
    if($("."+name).val() == ""){
        defaultVal = $("."+name).attr('id');
        $("."+name).html(defaultVal);
    }

    if(value != "" && name != 'unknown'){
        $("."+name).html(value);
    }
});

$("input").bind('input propertychange', function(){
    name = $(this).attr('name');
    value = $(this).val();
    
    if($("."+name).val() == ""){
        defaultVal = $("."+name).attr('id');
        $("."+name).html(defaultVal);
    }

    if(value != "" && name != 'unknown'){
        $("."+name).html(value);
    }
});