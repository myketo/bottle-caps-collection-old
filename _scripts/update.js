// fill inputs values when page is loaded
window.onload = function(){
    info = ['brand', 'caption', 'color', 'country', 'unknown'];

    for(let i=0; i<info.length; i++){
        content = $("."+info[i]).text();
        $("#upd_"+info[i]).val(content);
    }
}

// if checkbox is checked then show its div
if($('#upd_unknown').attr('checked')){
    $(".unknown").css("display", "block");
}


// if user changed checkbox then show/hide its div
$("#upd_unknown").click(function(){
    if($(".unknown").css("display") == "none"){
        $(".unknown").css("display", "block");
    }else{
        $(".unknown").css("display", "none");
    }
});


// show selected file name
$("#upd_image").change(function() {
    filename = this.files[0].name;
    $(".over_file").html(filename);
});


// access file input through key press on its label
$(".over_file").keypress(function(e) {
    if(e.key === " " || e.key === "Spacebar" || e.key==="Enter"){
        e.preventDefault();
        $("#upd_image").click();
    }
});


// show image on the preview
$("#upd_image").change(function() {
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

// display inputs value in the preview
$("input").keyup(function(){
    name = $(this).attr('name');
    value = $(this).val();
    
    if($("."+name).val() == ""){
        defaultVal = $("."+name).attr('id');
        $("."+name).html(defaultVal);
    }

    if(value != ""){
        $("."+name).html(value);
    }
});